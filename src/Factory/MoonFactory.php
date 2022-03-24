<?php

namespace App\Factory;

use App\Entity\Moon;
use App\Interface\WorldInterface;
use Exception;

class MoonFactory
{
    public function create(int $width, int $height): WorldInterface
    {
        return new Moon($width, $height);
    }

    public function createFromCoordinates(string $coordinates): WorldInterface
    {
        preg_match('/([0-9]+) +([0-9]+)/', trim($coordinates), $matches);

        if (count($matches) === 0) {
            throw new Exception('Moon size must be specified as "m n"');
        }

        $width  = (int) $matches[1];
        $height = (int) $matches[2];

        return $this->create($width, $height);
    }
}
