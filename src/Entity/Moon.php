<?php

namespace App\Entity;

use App\Interface\WorldInterface;

class Moon implements WorldInterface
{
    public function __construct(protected int $width, protected int $height) {}

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
