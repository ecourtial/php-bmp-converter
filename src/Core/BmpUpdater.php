<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

class BmpUpdater
{
    private PhpCore $phpCore;

    public function __construct(PhpCore $phpCore)
    {
        $this->phpCore = $phpCore;
    }

    public function update(BmpImage $image): void
    {
        if ($image->is24Bits()) {
            $imageFile = $this->phpCore->imageCreateTrueColor($image->getWidth(), $image->getHeight());
        } else {
            throw new \Exception("Sorry, but so far the library only supports edition of 24bits BMP files.");
        }

        foreach ($image->getPixels() as $pixel) {
            $color =  $this->phpCore->imageColorAllocate($imageFile, $pixel->getR(), $pixel->getG(), $pixel->getB());
            imagesetpixel($imageFile, $pixel->getX(), $pixel->getY(), $color);
        }

        imagebmp($imageFile, $image->getPath());
    }
}
