<?php

namespace App\Interface;

interface PositionInterface
{
    public function getPositionX(): int;

    public function setPositionX(int $x): void;

    public function getPositionY(): int;

    public function setPositionY(int $y): void;

    public function getDirection(): string;

    public function setDirection(string $direction): void;

    public function getCurrentPosition(): string;
}
