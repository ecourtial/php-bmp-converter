<?php

namespace Tests\Core;

use Ecourtial\PhpBmpParser\Core\PhpCore;
use Ecourtial\PhpBmpParser\Core\BmpParser;
use PHPUnit\Framework\TestCase;

class BmpParserTest extends TestCase
{
    private string $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Assets' . DIRECTORY_SEPARATOR;

    public function testUnpackHeaderWithException(): void
    {
        $parser = new BmpParser(new PhpCore());
        static::expectExceptionMessage('Impossible to unpack the header of the file!');
        $parser->get($this->path . 'eric.txt');
    }

    public function testUnknownPalette(): void
    {
        $parser = new BmpParser(new PhpCore());
        static::expectExceptionMessage('The given palette is not supported!');
        $parser->get($this->path . 'monochrome.bmp');
    }
}
