<?php

declare(strict_types=1);

namespace Ecourtial\PhpBmpParser\Core;

class Pixel
{
    private int $x;
    private int $y;
    private int $r;
    private int $g;
    private int $b;
    private string $hex;

    public function __construct(int $x, int $y, int $r, int $g, int $b, string $hex)
    {

        $this->x = $x;
        $this->y = $y;
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->hex = $hex;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getR(): int
    {
        return $this->r;
    }

    public function getG(): int
    {
        return $this->g;
    }

    public function getB(): int
    {
        return $this->b;
    }

    public function getHex(): string
    {
        return $this->hex;
    }

    public function setR(int $r): self
    {
        $this->r = $r;

        return $this;
    }

    public function setG(int $g): self
    {
        $this->g = $g;

        return $this;
    }

    public function setB(int $b): self
    {
        $this->b = $b;

        return $this;
    }
}
