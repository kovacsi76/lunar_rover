<?php

namespace App\Model;

class RoverCommand
{
    public const LEFT = 'L';
    public const RIGHT = 'R';
    public const FORWARD = 'F';

    public const VALID_MOVEMENTS = [
        RoverCommand::LEFT,
        RoverCommand::RIGHT,
        RoverCommand::FORWARD
    ];
}
