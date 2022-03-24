<?php

namespace App\Entity;

use App\Exception\VehicleLostException;
use App\Interface\PositionInterface;
use App\Interface\WorldInterface;

class RoverPosition implements PositionInterface
{
    protected bool $isLost = false;

    public function __construct(
        protected WorldInterface $world,
        protected int $x,
        protected int $y,
        protected string $direction
    ) {}

    public function getPositionX(): int
    {
        return $this->x;
    }

    public function setPositionX(int $x): void
    {
        if ($x < 0 || $x > $this->world->getWidth()) {
            $this->isLost = true;

            throw new VehicleLostException('Rover lost');
        }
        $this->x = $x;
    }

    public function getPositionY(): int
    {
        return $this->y;
    }

    public function setPositionY(int $y): void
    {
        if ($y < 0 || $y > $this->world->getHeight()) {
            $this->isLost = true;

            throw new VehicleLostException('Rover lost');
        }
        $this->y = $y;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    public function getCurrentPosition(): string
    {
        return '[' . $this->x . ', ' . $this->y . ', ' . $this->direction . ']' .  ($this->isLost ? ' LOST' : '');
    }
}
