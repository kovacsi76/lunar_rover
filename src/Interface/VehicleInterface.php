<?php

namespace App\Interface;

interface VehicleInterface
{
    public function getPosition(): PositionInterface;

    public function getCommand(): CommandInterface;
}
