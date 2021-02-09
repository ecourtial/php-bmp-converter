<?php

namespace Tests;

use Ecourtial\PhpBmpParser\BmpService;
use PHPUnit\Framework\TestCase;

class BmpServiceTest extends TestCase
{
    private string $path = __DIR__ . DIRECTORY_SEPARATOR . 'Assets' . DIRECTORY_SEPARATOR;

    public function testParse4bitsImage(): void
    {
        $service = new BmpService();
        $path = $this->path . '4bits.bmp';
        $image = $service->getImage($path);

        // Check global data
        static::assertEquals('BM', $image->getType());
        static::assertEquals(126, $image->getFileBytesSize());
        static::assertEquals(40, $image->getDibHeaderSize());
        static::assertEquals(118, $image->getStartOffset());
        static::assertEquals(2, $image->getWidth());
        static::assertEquals(2, $image->getHeight());
        static::assertEquals(1, $image->getColorPlaneCount());
        static::assertEquals(4, $image->getBitsPerPixel());
        static::assertEquals(0, $image->getCompressionMethod());
        static::assertEquals(8, $image->getImageBytesSize());
        static::assertEquals(3780, $image->getHorizontalResolution());
        static::assertEquals(3780, $image->getVerticalResolution());
        static::assertEquals(0, $image->getColorPaletteCount());
        static::assertEquals(0, $image->getImportantColors());
        static::assertEquals($path, $image->getPath());

        static::assertFalse($image->is24Bits());
        static::assertFalse($image->is256Colors());
        static::assertTrue($image->is16Colors());

        // Check pixels location
        $pixel0 = $image->getPixel(0, 0);
        $pixel1 = $image->getPixel(1, 0);
        $pixel2 = $image->getPixel(0, 1);
        $pixel3 = $image->getPixel(1, 1);

        static::assertEquals($pixel0, $image->getPixels()["0-0"]);
        static::assertEquals($pixel1, $image->getPixels()["1-0"]);
        static::assertEquals($pixel2, $image->getPixels()["0-1"]);
        static::assertEquals($pixel3, $image->getPixels()["1-1"]);

        // Check Pixels Content
        static::assertEquals(0, $pixel0->getX());
        static::assertEquals(0, $pixel0->getY());
        static::assertEquals(255, $pixel0->getR());
        static::assertEquals(0, $pixel0->getG());
        static::assertEquals(0, $pixel0->getB());
        static::assertEquals('9', $pixel0->getHex());

        static::assertEquals(1, $pixel1->getX());
        static::assertEquals(0, $pixel1->getY());
        static::assertEquals(255, $pixel1->getR());
        static::assertEquals(255, $pixel1->getG());
        static::assertEquals(255, $pixel1->getB());
        static::assertEquals('f', $pixel1->getHex());

        static::assertEquals(0, $pixel2->getX());
        static::assertEquals(1, $pixel2->getY());
        static::assertEquals(255, $pixel2->getR());
        static::assertEquals(255, $pixel2->getG());
        static::assertEquals(255, $pixel2->getB());
        static::assertEquals('f', $pixel2->getHex());

        static::assertEquals(1, $pixel3->getX());
        static::assertEquals(1, $pixel3->getY());
        static::assertEquals(0, $pixel3->getR());
        static::assertEquals(0, $pixel3->getG());
        static::assertEquals(255, $pixel3->getB());
        static::assertEquals('c', $pixel3->getHex());
    }

    public function testParse8bitsImage(): void
    {
        $service = new BmpService();
        $path = $this->path . '8bits.bmp';
        $image = $service->getImage($path);

        // Check global data
        static::assertEquals('BM', $image->getType());
        static::assertEquals(1086, $image->getFileBytesSize());
        static::assertEquals(40, $image->getDibHeaderSize());
        static::assertEquals(1078, $image->getStartOffset());
        static::assertEquals(2, $image->getWidth());
        static::assertEquals(2, $image->getHeight());
        static::assertEquals(1, $image->getColorPlaneCount());
        static::assertEquals(8, $image->getBitsPerPixel());
        static::assertEquals(0, $image->getCompressionMethod());
        static::assertEquals(8, $image->getImageBytesSize());
        static::assertEquals(3780, $image->getHorizontalResolution());
        static::assertEquals(3780, $image->getVerticalResolution());
        static::assertEquals(0, $image->getColorPaletteCount());
        static::assertEquals(0, $image->getImportantColors());
        static::assertEquals($path, $image->getPath());

        static::assertFalse($image->is24Bits());
        static::assertTrue($image->is256Colors());
        static::assertFalse($image->is16Colors());

        // Check pixels location
        $pixel0 = $image->getPixel(0, 0);
        $pixel1 = $image->getPixel(1, 0);
        $pixel2 = $image->getPixel(0, 1);
        $pixel3 = $image->getPixel(1, 1);

        static::assertEquals($pixel0, $image->getPixels()["0-0"]);
        static::assertEquals($pixel1, $image->getPixels()["1-0"]);
        static::assertEquals($pixel2, $image->getPixels()["0-1"]);
        static::assertEquals($pixel3, $image->getPixels()["1-1"]);

        // Check Pixels Content
        static::assertEquals(0, $pixel0->getX());
        static::assertEquals(0, $pixel0->getY());
        static::assertEquals(255, $pixel0->getR());
        static::assertEquals(0, $pixel0->getG());
        static::assertEquals(0, $pixel0->getB());
        static::assertEquals('e0', $pixel0->getHex());

        static::assertEquals(1, $pixel1->getX());
        static::assertEquals(0, $pixel1->getY());
        static::assertEquals(255, $pixel1->getR());
        static::assertEquals(255, $pixel1->getG());
        static::assertEquals(255, $pixel1->getB());
        static::assertEquals('ff', $pixel1->getHex());

        static::assertEquals(0, $pixel2->getX());
        static::assertEquals(1, $pixel2->getY());
        static::assertEquals(255, $pixel2->getR());
        static::assertEquals(255, $pixel2->getG());
        static::assertEquals(255, $pixel2->getB());
        static::assertEquals('ff', $pixel2->getHex());

        static::assertEquals(1, $pixel3->getX());
        static::assertEquals(1, $pixel3->getY());
        static::assertEquals(0, $pixel3->getR());
        static::assertEquals(0, $pixel3->getG());
        static::assertEquals(255, $pixel3->getB());
        static::assertEquals('03', $pixel3->getHex());
    }

    public function testParse24bitsImage(): void
    {
        $service = new BmpService();
        $path = $this->path . '24bits.bmp';
        $image = $service->getImage($path);

        // Check global data
        static::assertEquals('BM', $image->getType());
        static::assertEquals(70, $image->getFileBytesSize());
        static::assertEquals(40, $image->getDibHeaderSize());
        static::assertEquals(54, $image->getStartOffset());
        static::assertEquals(2, $image->getWidth());
        static::assertEquals(2, $image->getHeight());
        static::assertEquals(1, $image->getColorPlaneCount());
        static::assertEquals(24, $image->getBitsPerPixel());
        static::assertEquals(0, $image->getCompressionMethod());
        static::assertEquals(16, $image->getImageBytesSize());
        static::assertEquals(3780, $image->getHorizontalResolution());
        static::assertEquals(3780, $image->getVerticalResolution());
        static::assertEquals(0, $image->getColorPaletteCount());
        static::assertEquals(0, $image->getImportantColors());
        static::assertEquals($path, $image->getPath());

        static::assertTrue($image->is24Bits());
        static::assertFalse($image->is256Colors());
        static::assertFalse($image->is16Colors());

        // Check pixels location
        $pixel0 = $image->getPixel(0, 0);
        $pixel1 = $image->getPixel(1, 0);
        $pixel2 = $image->getPixel(0, 1);
        $pixel3 = $image->getPixel(1, 1);

        static::assertEquals($pixel0, $image->getPixels()["0-0"]);
        static::assertEquals($pixel1, $image->getPixels()["1-0"]);
        static::assertEquals($pixel2, $image->getPixels()["0-1"]);
        static::assertEquals($pixel3, $image->getPixels()["1-1"]);

        // Check Pixels Content
        static::assertEquals(0, $pixel0->getX());
        static::assertEquals(0, $pixel0->getY());
        static::assertEquals(255, $pixel0->getR());
        static::assertEquals(0, $pixel0->getG());
        static::assertEquals(0, $pixel0->getB());
        static::assertEquals('0000ff', $pixel0->getHex());

        static::assertEquals(1, $pixel1->getX());
        static::assertEquals(0, $pixel1->getY());
        static::assertEquals(255, $pixel1->getR());
        static::assertEquals(255, $pixel1->getG());
        static::assertEquals(255, $pixel1->getB());
        static::assertEquals('ffffff', $pixel1->getHex());

        static::assertEquals(0, $pixel2->getX());
        static::assertEquals(1, $pixel2->getY());
        static::assertEquals(255, $pixel2->getR());
        static::assertEquals(255, $pixel2->getG());
        static::assertEquals(255, $pixel2->getB());
        static::assertEquals('ffffff', $pixel2->getHex());

        static::assertEquals(1, $pixel3->getX());
        static::assertEquals(1, $pixel3->getY());
        static::assertEquals(0, $pixel3->getR());
        static::assertEquals(0, $pixel3->getG());
        static::assertEquals(255, $pixel3->getB());
        static::assertEquals('ff0000', $pixel3->getHex());
    }

    public function testUpdate24bitsImageWithSizeIncreasedAndColorModification(): void
    {
        $service = new BmpService();
        $path = $this->path . '24bitsToInc.bmp';
        $image = $service->getImage($path);
        $outputPath = $this->path . 'Output' . DIRECTORY_SEPARATOR . '24bitsInc.bmp';

        // Change the path to not alter the original one
        $image->setPath($outputPath);
        // change the color of one specific pixel
        $image->getPixel(0, 1)->setR(0)->setG(0)->setB(126);
        // Change the size of the image (extra pixel filled with white)
        $image->setDimensions(3, 4);
        // Change the color of one of the pixel added because we increased the width
        $image->getPixel(2, 0)->setR(0)->setG(34)->setB(0);
        $image->getPixel(1, 3)->setR(200)->setG(0)->setB(200);
        $image->getPixel(1, 1)->setR(0)->setG(0)->setB(255);

        // The image object is reloaded on update
        $image = $service->update($image);

        // Tests
        static::assertEquals(12, count($image->getPixels()));

        static::assertEquals(90, $image->getFileBytesSize());
        static::assertEquals(40, $image->getDibHeaderSize());
        static::assertEquals(54, $image->getStartOffset());
        static::assertEquals(3, $image->getWidth());
        static::assertEquals(4, $image->getHeight());
        static::assertEquals(1, $image->getColorPlaneCount());
        static::assertEquals(24, $image->getBitsPerPixel());
        static::assertEquals(0, $image->getCompressionMethod());
        static::assertEquals(36, $image->getImageBytesSize());
        static::assertEquals(0, $image->getHorizontalResolution());
        static::assertEquals(0, $image->getVerticalResolution());
        static::assertEquals(0, $image->getColorPaletteCount());
        static::assertEquals(0, $image->getImportantColors());

        // Check Pixels Content
        $pixel0 = $image->getPixel(0, 0);
        $pixel1 = $image->getPixel(1, 0);
        $pixel2 = $image->getPixel(2, 0);

        $pixel3 = $image->getPixel(0, 1);
        $pixel4 = $image->getPixel(1, 1);
        $pixel5 = $image->getPixel(2, 1);

        $pixel6 = $image->getPixel(0, 2);
        $pixel7 = $image->getPixel(1, 2);
        $pixel8 = $image->getPixel(2, 2);

        $pixel9 = $image->getPixel(0, 3);
        $pixel10 = $image->getPixel(1, 3);
        $pixel11 = $image->getPixel(2, 3);

        static::assertEquals(0, $pixel0->getX());
        static::assertEquals(0, $pixel0->getY());
        static::assertEquals(255, $pixel0->getR());
        static::assertEquals(0, $pixel0->getG());
        static::assertEquals(0, $pixel0->getB());
        static::assertEquals('0000ff', $pixel0->getHex());

        static::assertEquals(1, $pixel1->getX());
        static::assertEquals(0, $pixel1->getY());
        static::assertEquals(255, $pixel1->getR());
        static::assertEquals(255, $pixel1->getG());
        static::assertEquals(255, $pixel1->getB());
        static::assertEquals('ffffff', $pixel1->getHex());

        static::assertEquals(2, $pixel2->getX());
        static::assertEquals(0, $pixel2->getY());
        static::assertEquals(0, $pixel2->getR());
        static::assertEquals(34, $pixel2->getG());
        static::assertEquals(0, $pixel2->getB());
        static::assertEquals('002200', $pixel2->getHex());

        static::assertEquals(0, $pixel3->getX());
        static::assertEquals(1, $pixel3->getY());
        static::assertEquals(0, $pixel3->getR());
        static::assertEquals(0, $pixel3->getG());
        static::assertEquals(126, $pixel3->getB());
        static::assertEquals('7e0000', $pixel3->getHex());

        static::assertEquals(1, $pixel4->getX());
        static::assertEquals(1, $pixel4->getY());
        static::assertEquals(0, $pixel4->getR());
        static::assertEquals(0, $pixel4->getG());
        static::assertEquals(255, $pixel4->getB());
        static::assertEquals('ff0000', $pixel4->getHex());

        static::assertEquals(2, $pixel5->getX());
        static::assertEquals(1, $pixel5->getY());
        static::assertEquals(255, $pixel5->getR());
        static::assertEquals(255, $pixel5->getG());
        static::assertEquals(255, $pixel5->getB());
        static::assertEquals('ffffff', $pixel5->getHex());

        static::assertEquals(0, $pixel6->getX());
        static::assertEquals(2, $pixel6->getY());
        static::assertEquals(255, $pixel6->getR());
        static::assertEquals(255, $pixel6->getG());
        static::assertEquals(255, $pixel6->getB());
        static::assertEquals('ffffff', $pixel6->getHex());

        static::assertEquals(1, $pixel7->getX());
        static::assertEquals(2, $pixel7->getY());
        static::assertEquals(255, $pixel7->getR());
        static::assertEquals(255, $pixel7->getG());
        static::assertEquals(255, $pixel7->getB());
        static::assertEquals('ffffff', $pixel7->getHex());

        static::assertEquals(2, $pixel8->getX());
        static::assertEquals(2, $pixel8->getY());
        static::assertEquals(255, $pixel8->getR());
        static::assertEquals(255, $pixel8->getG());
        static::assertEquals(255, $pixel8->getB());
        static::assertEquals('ffffff', $pixel8->getHex());

        static::assertEquals(0, $pixel9->getX());
        static::assertEquals(3, $pixel9->getY());
        static::assertEquals(255, $pixel9->getR());
        static::assertEquals(255, $pixel9->getG());
        static::assertEquals(255, $pixel9->getB());
        static::assertEquals('ffffff', $pixel9->getHex());

        static::assertEquals(1, $pixel10->getX());
        static::assertEquals(3, $pixel10->getY());
        static::assertEquals(200, $pixel10->getR());
        static::assertEquals(0, $pixel10->getG());
        static::assertEquals(200, $pixel10->getB());
        static::assertEquals('c800c8', $pixel10->getHex());

        static::assertEquals(2, $pixel11->getX());
        static::assertEquals(3, $pixel11->getY());
        static::assertEquals(255, $pixel11->getR());
        static::assertEquals(255, $pixel11->getG());
        static::assertEquals(255, $pixel11->getB());
        static::assertEquals('ffffff', $pixel11->getHex());
    }

    public function testUpdate24bitsImageWithSizeDecreasedAndColorModification(): void
    {
        $service = new BmpService();
        $path = $this->path . '24bitsToDec.bmp';
        $image = $service->getImage($path);
        $outputPath = $this->path . 'Output' . DIRECTORY_SEPARATOR . '24bitsDec.bmp';

        // Change the path to not alter the original one
        $image->setPath($outputPath);
        // change the color of one specific pixel
        $image->getPixel(1, 0)->setR(200)->setG(0)->setB(200);
        // Change the size of the image
        $image->setDimensions(1, 2);

        // The image object is reloaded on update
        $image = $service->update($image);

        // Tests
        static::assertEquals(2, count($image->getPixels()));

        static::assertEquals(60, $image->getFileBytesSize());
        static::assertEquals(40, $image->getDibHeaderSize());
        static::assertEquals(54, $image->getStartOffset());
        static::assertEquals(1, $image->getWidth());
        static::assertEquals(2, $image->getHeight());
        static::assertEquals(1, $image->getColorPlaneCount());
        static::assertEquals(24, $image->getBitsPerPixel());
        static::assertEquals(0, $image->getCompressionMethod());
        static::assertEquals(6, $image->getImageBytesSize());
        static::assertEquals(0, $image->getHorizontalResolution());
        static::assertEquals(0, $image->getVerticalResolution());
        static::assertEquals(0, $image->getColorPaletteCount());
        static::assertEquals(0, $image->getImportantColors());

        // Check Pixels Content
        $pixel0 = $image->getPixel(0, 0);
        $pixel1 = $image->getPixel(0, 1);

        static::assertEquals(0, $pixel0->getX());
        static::assertEquals(0, $pixel0->getY());
        static::assertEquals(255, $pixel0->getR());
        static::assertEquals(0, $pixel0->getG());
        static::assertEquals(0, $pixel0->getB());
        static::assertEquals('0000ff', $pixel0->getHex());

        static::assertEquals(0, $pixel1->getX());
        static::assertEquals(1, $pixel1->getY());
        static::assertEquals(0, $pixel1->getR());
        static::assertEquals(0, $pixel1->getG());
        static::assertEquals(126, $pixel1->getB());
        static::assertEquals('7e0000', $pixel1->getHex());
    }

    public function testEditNotSupported(): void
    {
        $service = new BmpService();
        $path = $this->path . '4bits.bmp';
        $image = $service->getImage($path);
        static::expectExceptionMessage('Sorry, but so far the library only supports edition of 24bits BMP files.');
        $service->update($image);
    }
}
