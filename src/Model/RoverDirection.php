<?php

namespace App\Model;

class RoverDirection
{
    public const NORTH = 'N';
    public const EAST = 'E';
    public const SOUTH = 'S';
    public const WEST = 'W';

    public const X_AXIS = [
        RoverDirection::EAST,
        RoverDirection::WEST,
    ];

    public const Y_AXIS = [
        RoverDirection::NORTH,
        RoverDirection::SOUTH,
    ];

    public const VALID_DIRECTIONS = [
        ...RoverDirection::X_AXIS,
        ...RoverDirection::Y_AXIS,
    ];
}
