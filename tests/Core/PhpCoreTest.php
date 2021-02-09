<?php

namespace Tests\Core;

use Ecourtial\PhpBmpParser\Core\PhpCore;
use PHPUnit\Framework\TestCase;

class PhpCoreTest extends TestCase
{
    private string $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Assets' . DIRECTORY_SEPARATOR;

    private static PhpCore $core;

    public static function setUpBeforeClass(): void
    {
        static::$core = new PhpCore();
    }

    public function testGetFileSizeWithSuccess(): void
    {
        static::assertEquals(126, static::$core->getFileSize($this->path . '4bits.bmp'));
    }

    public function testGetFileSizeWithFailure(): void
    {
        static::expectExceptionMessage('Impossible to assert the size of the given file!');
        static::$core->getFileSize($this->path . '4bitsssss.bmp');
    }

    public function testOpenWithSuccess(): void
    {
        static::assertTrue(is_resource(static::$core->fopen($this->path . '4bits.bmp')));
    }

    public function testOpenWithFailure(): void
    {
        static::expectExceptionMessage('Impossible to open the given file!');
        static::$core->fopen($this->path . '4bitsssss.bmp');
    }

    public function testReadWithSuccess(): void
    {
        $path = $this->path . '4bits.bmp';
        $resource = static::$core->fopen($path);
        static::assertEquals(8.813141016352169E+37, hexdec(bin2hex(static::$core->fread($resource, 16))));
    }

    public function testUnpackWithSuccess(): void
    {
        $binarydata = "\x04\x00\xa0\x00";
        $array = static::$core->unpack("cchars/nint", $binarydata);
        static::assertEquals(['chars' => 4, 'int' => 160], $array);
    }

    public function testUnpackWithFailure(): void
    {
        $binarydata = "";
        static::expectExceptionMessage('Impossible to unpack the header of the file!');
        static::$core->unpack("cchars/nint", $binarydata);
    }

    public function testStrSplitWithSuccess(): void
    {
        $str = "Hello Friend";
        static::assertEquals(
            [
                0 => 'Hel',
                1 => 'lo ',
                2 => 'Fri',
                3 => 'end',
            ],
            static::$core->strSplit($str, 3, 'row')
        );
    }

    public function testStrSplitWithFailure(): void
    {
        static::expectExceptionMessage("Impossible to splint the given string of type: 'row' at 4");
        static::$core->strSplit('', 0, 'row', 4);
    }

    public function testImageCreateTrueColorWithSuccess(): void
    {
        static::assertTrue(is_resource(static::$core->imageCreateTrueColor(10, 10)));
    }

    public function testImageCreateTrueColorWithFailure(): void
    {
        static::expectExceptionMessage('Impossible to create the image!');
        static::$core->imageCreateTrueColor(0, 0);
    }

    public function testImageColorAllocateWithSuccess(): void
    {
        $image = static::$core->imageCreateTrueColor(10, 10);
        static::assertEquals(16711680, static::$core->imageColorAllocate($image, 255, 0, 0));
    }

    public function testColorAllocateWithFailure(): void
    {
        static::expectExceptionMessage('Image must be a resource!');
        static::$core->imageColorAllocate(null, 255, 00, 0);

        $image = static::$core->imageCreateTrueColor(10, 10);
        static::expectExceptionMessage("Impossible to create the color with RGB a, 0, 0!");
        static::$core->imageColorAllocate($image, 'a', 0, 0);
    }
}
