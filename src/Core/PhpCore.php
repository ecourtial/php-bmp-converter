<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

class PhpCore
{
    public function getFileSize(string $filePath): int
    {
        $fileSize = @\filesize($filePath);

        if (false === is_int($fileSize)) {
            throw new \Exception('Impossible to assert the size of the given file!');
        }

        return $fileSize;
    }

    /** @phpstan-ignore-next-line */
    public function fopen($filePath)
    {
        $file = @\fopen($filePath, "rb");

        if (false === is_resource($file)) {
            throw new \Exception('Impossible to open the given file!');
        }

        return $file;
    }

    /** @phpstan-ignore-next-line */
    public function fread($resource, $fileLength): string
    {
        $raw = @\fread($resource, $fileLength);

        if (false === is_string($raw)) {
            throw new \Exception('Impossible to read the given file!');
        }

        return $raw;
    }

    /** @return string[] */
    public function unpack(string $format, string $string): array
    {
        $data = @\unpack($format, $string);

        if (false === is_array($data)) {
            throw new \Exception('Impossible to unpack the header of the file!');
        }

        return $data;
    }

    /** @return string[] */
    public function strSplit(string $string, int $length, string $what, string $extra = ''): array
    {
        $data = @\str_split($string, $length);

        if (false === is_array($data) || 0 === count($data)) {
            $msg = "Impossible to splint the given string of type: '$what'";
            $msg = $extra === '' ? $msg : $msg . ' at ' . $extra;

            throw new \Exception($msg);
        }

        return $data;
    }

    /** @phpstan-ignore-next-line */
    public function imageCreateTrueColor(int $width, int $height)
    {
        $imageFile = @\imagecreatetruecolor($width, $height);

        if (false === $imageFile) {
            throw new \Exception("Impossible to create the image!");
        }

        return $imageFile;
    }

    /** @phpstan-ignore-next-line */
    public function imageColorAllocate($image, int $r, int $g, int $b): int
    {
        if (false === is_resource($image)) {
            throw new \Exception('Image must be a resource!');
        }

        $color = @\imagecolorallocate($image, $r, $g, $b);

        if (false === $color) {
            throw new \Exception("Impossible to create the color with RGB $r, $g, $b!");
        }

        return $color;
    }
}
