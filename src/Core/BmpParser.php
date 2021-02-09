<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

class BmpParser
{
    public const HEADER_LENGTH = 54;

    private PhpCore $phpCore;

    public function __construct(PhpCore $phpCore)
    {
        $this->phpCore = $phpCore;
    }

    public function get(string $path): BmpImage
    {
        $binaries = $this->extractBinaries($path);
        $headerData = $this->parseHeader($binaries);

        return new BmpImage($path, $headerData, $this->getPixels($headerData, $binaries));
    }

    private function extractBinaries(string $filePath): string
    {
        return $this->phpCore->fread($this->phpCore->fopen($filePath), $this->phpCore->getFileSize($filePath));
    }

    /** @return mixed[] */
    private function parseHeader(string $raw): array
    {
        $header = substr($raw, 0, self::HEADER_LENGTH);

        return $this->phpCore->unpack(
            'a2type/' .   //00-2b - header to identify file type
            'Vfile_size/' .      //02-4b - size of bmp in bytes
            'vreserved1/' .      //06-2b - reserved
            'vreserved2/' .      //08-2b - reserved
            'Vbitmap_start/' .   //10-4b - offset of where bmp pixel array can be found
            'Vdib_size/' .      //14-4b - size of dib header
            'Vwidth/' .          //18-4b - width on pixels
            'Vheight/' .         //22-4b - height in pixels
            'vcolor_planes/' .   //26-2b - number of color planes
            'vbits_pixel/' .     //28-2b - bits per pixel
            'Vcompression/' .    //30-4b - compression method
            'Vimage_size/' .     //34-4b - image size in bytes
            'Vh_resolution/' .   //38-4b - horizontal resolution
            'Vv_resolution/' .   //42-4b - vertical resolution
            'Vcolor_palette/' .  //46-4b - number of colors in palette
            'Vimp_colors/',      //50-4b - important colors
            $header
        );
    }

    /**
     * @param mixed[] $header
     * @return Pixel[]
     */
    private function getPixels(array &$header, string &$binaries): array
    {
        $width = (int) $header['width'];
        $height  = $header['height'];
        $start  = $header['bitmap_start'];
        $bitsPerPixel  = (int) $header['bits_pixel'];
        $dibSize = $header['dib_size'];
        $headerSize = 14;
        $paletteSize = pow(2, $bitsPerPixel) * 4;
        $supportedPalettes = ['4','8','24'];
        $pixelsObjects = [];

        if (false === in_array($bitsPerPixel, $supportedPalettes)) {
            throw new \Exception('The given palette is not supported!');
        }

        $colorPalette = null;

        // Extract the color palette for 4 bits (16 colors) and 8 bits (256 colors) images.
        if ($bitsPerPixel <= 8) {
            $colorPalette = substr($binaries, $headerSize + $dibSize, $paletteSize); // Extract the color palette after header
            $colorPalette = bin2hex($colorPalette);
            $colorPalette = str_split($colorPalette, 8); // Splitting into color codes
        }

        // Trim the header and convert
        $binaries = substr($binaries, $start);
        $binaries = bin2hex($binaries);

        // Get row size with padding
        $rowSize = (int) ceil(($bitsPerPixel * $width / 8) / 4) * 8;

        // Split body into rows
        $binaries = $this->phpCore->strSplit($binaries, $rowSize, 'body');

        // Parse the body
        for ($line = 0; $line < $height; $line++) {
            $row = $binaries[abs(($height - 1) - $line)];
            $row = substr($row, 0, $width * $bitsPerPixel / 4);
            $pixels =  $this->phpCore->strSplit($row, $bitsPerPixel / 4, 'line', "#$line");

            // Parse the line
            for ($x = 0; $x < $width; $x++) {
                if ($bitsPerPixel == 24) { // 24 bits bitmap
                    [$r, $g, $b] = $this->getImageColorFrom24BitsPalette($pixels[$x]);
                } else { // Palette is defined (4 and 8 bits)
                    [$r, $g, $b] = $this->getImageColorFromPalette($pixels[$x], $colorPalette);
                }

                $pixelsObjects["$x-$line"] = new Pixel($x, $line, $r, $g, $b, $pixels[$x]);
            }
        }

        return $pixelsObjects;
    }

    /**
     * Extract RGB for 24 bits images
     *
     * @return int[]
     */
    private function getImageColorFrom24BitsPalette(string $pixel): array
    {
        $colorData = $this->phpCore->strSplit($pixel, 2, 'color data');

        return [(int) hexdec($colorData[2]), (int) hexdec($colorData[1]), (int) hexdec($colorData[0])];
    }

    /**
     * Extract RGB for 4 and 8 bits images
     *
     * @param mixed[] $colorPalette
     *
     * @return int[]
     */
    private function getImageColorFromPalette(string $pixel, ?array $colorPalette = null)
    {
        if (null !== $colorPalette) { // If the palette is defined, we get the RGB values from it
            $r = (int) hexdec(substr($colorPalette[hexdec($pixel)], 4, 2));
            $g = (int) hexdec(substr($colorPalette[hexdec($pixel)], 2, 2));
            $b = (int) hexdec(substr($colorPalette[hexdec($pixel)], 0, 2));
        } else {
            throw new \Exception('The BMP palette is unknown');
        }

        return [$r, $g, $b];
    }
}
