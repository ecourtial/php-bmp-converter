<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser;

use Ecourtial\PhpBmpParser\Core\BmpImage;
use Ecourtial\PhpBmpParser\Core\BmpParser;
use Ecourtial\PhpBmpParser\Core\BmpUpdater;
use Ecourtial\PhpBmpParser\Core\PhpCore;

class BmpService
{
    private ?BmpParser $bmpParser = null;
    private ?BmpUpdater $bmpUpdater = null;

    public function getImage(string $path): BmpImage
    {
        if (null === $this->bmpParser) {
            $this->bmpParser = new BmpParser(new PhpCore());
        }

        return $this->bmpParser->get($path);
    }

    public function update(BmpImage $image): BmpImage
    {
        if (null === $this->bmpUpdater) {
            $this->bmpUpdater = new BmpUpdater(new PhpCore());
        }

        $this->bmpUpdater->update($image);

        return $this->getImage($image->getPath());
    }
}
