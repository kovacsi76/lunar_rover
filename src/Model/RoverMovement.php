<?php

namespace App\Model;

class RoverMovement
{
    public const LEFT = [
        RoverDirection::NORTH => RoverDirection::WEST,
        RoverDirection::EAST => RoverDirection::NORTH,
        RoverDirection::SOUTH => RoverDirection::EAST,
        RoverDirection::WEST => RoverDirection::SOUTH,
    ];

    public const RIGHT = [
        RoverDirection::NORTH => RoverDirection::EAST,
        RoverDirection::EAST => RoverDirection::SOUTH,
        RoverDirection::SOUTH => RoverDirection::WEST,
        RoverDirection::WEST => RoverDirection::NORTH,
    ];

    public const FORWARD = [
        RoverDirection::NORTH => 1,
        RoverDirection::EAST => 1,
        RoverDirection::SOUTH => -1,
        RoverDirection::WEST => -1,
    ];
}
