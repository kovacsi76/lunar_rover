<?php

namespace App\Entity;

use App\Interface\CommandInterface;
use App\Interface\PositionInterface;
use App\Interface\VehicleInterface;
use App\Interface\WorldInterface;

class RoverVehicle implements VehicleInterface
{
    public function __construct(
        protected WorldInterface $world,
        protected RoverPosition $roverPosition,
        protected RoverCommand $roverCommand
    ) {}

    public function getPosition(): PositionInterface
    {
        return $this->roverPosition;
    }

    public function getCommand(): CommandInterface
    {
        return $this->roverCommand;
    }
}
