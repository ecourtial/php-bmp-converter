<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

/**
 * This class has the purpose to mock native PHP function.
 * It mus be compatible with both PHP 7.4 and 8.
 */
class PhpCore
{
    public function getFileSize(string $filePath): int
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $fileSize = @\filesize($filePath);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $fileSize = false;
        }

        if (false === is_int($fileSize)) {
            throw new \Exception("Impossible to assert the size of the given file! $msg");
        }

        return $fileSize;
    }

    /** @phpstan-ignore-next-line */
    public function fopen($filePath)
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $file = @\fopen($filePath, "rb");
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $file = false;
        }

        if (false === is_resource($file)) {
            throw new \Exception("Impossible to open the given file! $msg");
        }

        return $file;
    }

    /** @phpstan-ignore-next-line */
    public function fread($resource, $fileLength): string
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $raw = @\fread($resource, $fileLength);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $raw = false;
        }

        if (false === is_string($raw)) {
            throw new \Exception("Impossible to read the given file! $msg");
        }

        return $raw;
    }

    /** @return string[] */
    public function unpack(string $format, string $string): array
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $data = @\unpack($format, $string);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $data = false;
        }

        if (false === is_array($data)) {
            throw new \Exception("Impossible to unpack the header of the file! $msg");
        }

        return $data;
    }

    /** @return string[] */
    public function strSplit(string $string, int $length, string $what, string $extra = ''): array
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $data = @\str_split($string, $length);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $data = false;
        }

        if (false === $data) {
            $error = "Impossible to splint the given string of type: '$what'";
            $error = $extra === '' ? $error : $error . ' at ' . $extra;
            $error .= " $msg";

            throw new \Exception($error);
        }

        return $data;
    }

    /** @phpstan-ignore-next-line */
    public function imageCreateTrueColor(int $width, int $height)
    {
        // This code must be compatible with both PHP7.4 and 8.
        try {
            $msg = '';
            $imageFile = @\imagecreatetruecolor($width, $height);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $imageFile = false;
        }

        /** @phpstan-ignore-next-line */
        if (false === is_resource($imageFile) && false === is_object($imageFile)) {
            throw new \Exception("Impossible to create the image! $msg");
        }

        return $imageFile;
    }

    /** @phpstan-ignore-next-line */
    public function imageColorAllocate($image, int $r, int $g, int $b): int
    {
        // This code must be compatible with both PHP7.4 and 8.
        if (false === is_resource($image) && false === is_object($image)) {
            throw new \Exception('Image must be a resource!' . gettype($image) . ' given.');
        }

        try {
            $msg = '';
            /** @phpstan-ignore-next-line */
            $color = @\imagecolorallocate($image, $r, $g, $b);
        } catch (\Throwable $exception) {
            $msg = $exception->getMessage();
            $color = false;
        }

        if (false === $color) {
            throw new \Exception("Impossible to create the color with RGB $r, $g, $b! $msg");
        }

        return $color;
    }
}
