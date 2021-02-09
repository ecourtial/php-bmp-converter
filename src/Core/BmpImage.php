<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

class BmpImage
{
    private string $path;
    private string $type;
    private int $fileBytesSize;
    private int $startOffset;
    private int $dibHeaderSize;
    private int $width;
    private int $height;
    private int $colorPlaneCount;
    private int $bitsPerPixel;
    private int $compressionMethod;
    private int $imageBytesSize;
    private int $horizontalResolution;
    private int $verticalResolution;
    private int $colorPaletteCount;
    private int $importantColors;

    /** @var Pixel[] */
    private array $pixels;

    /**
     * @param string $path
     * @param mixed[]  $headerData
     * @param Pixel[]  $pixels
     */
    public function __construct(string $path, array $headerData, array $pixels)
    {
        $this->path = $path;

        $this->type = $headerData['type'];
        $this->fileBytesSize = $headerData['file_size'];
        $this->startOffset = $headerData['bitmap_start'];
        $this->dibHeaderSize = $headerData['dib_size'];
        $this->width = $headerData['width'];
        $this->height = $headerData['height'];
        $this->colorPlaneCount = $headerData['color_planes'];
        $this->bitsPerPixel = $headerData['bits_pixel'];
        $this->compressionMethod = $headerData['compression'];
        $this->imageBytesSize = $headerData['image_size'];
        $this->horizontalResolution = $headerData['h_resolution'];
        $this->verticalResolution = $headerData['v_resolution'];
        $this->colorPaletteCount = $headerData['color_palette'];
        $this->importantColors = $headerData['imp_colors'];

        $this->pixels = $pixels;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFileBytesSize(): int
    {
        return $this->fileBytesSize;
    }

    public function getStartOffset(): int
    {
        return $this->startOffset;
    }

    public function getDibHeaderSize(): int
    {
        return $this->dibHeaderSize;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getColorPlaneCount(): int
    {
        return $this->colorPlaneCount;
    }

    public function getBitsPerPixel(): int
    {
        return $this->bitsPerPixel;
    }

    public function getCompressionMethod(): int
    {
        return $this->compressionMethod;
    }

    public function getImageBytesSize(): int
    {
        return $this->imageBytesSize;
    }

    public function getHorizontalResolution(): int
    {
        return $this->horizontalResolution;
    }

    public function getVerticalResolution(): int
    {
        return $this->verticalResolution;
    }

    public function getColorPaletteCount(): int
    {
        return $this->colorPaletteCount;
    }

    public function getImportantColors(): int
    {
        return $this->importantColors;
    }

    public function is24Bits(): bool
    {
        return $this->bitsPerPixel === 24;
    }

    public function is256Colors(): bool
    {
        return $this->bitsPerPixel === 8;
    }

    public function is16Colors(): bool
    {
        return $this->bitsPerPixel === 4;
    }

    /** @return Pixel[] */
    public function getPixels(): array
    {
        return $this->pixels;
    }

    public function getPixel(int $x, int $y): Pixel
    {
        return $this->pixels["$x-$y"];
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function setDimensions(int $width, int $height): void
    {
        $pixels = [];

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $key = "$x-$y";

                if (array_key_exists($key, $this->pixels)) {
                    $pixels[$key] = $this->pixels[$key];
                } else {
                    $this->pixels[$key] = new Pixel($x, $y, 255, 255, 255, 'FF');
                }

                $pixels["$x-$y"] = $this->pixels["$x-$y"];
            }
        }

        $this->pixels = $pixels;
        $this->width = $width;
        $this->height = $height;
    }
}
