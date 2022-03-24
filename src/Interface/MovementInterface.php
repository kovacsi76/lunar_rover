<?php

namespace App\Interface;

interface MovementInterface
{
    public function move(VehicleInterface $vehicle): void;
}
