<?php

namespace App\Factory;

use App\Entity\RoverPosition;
use App\Interface\PositionInterface;
use App\Interface\WorldInterface;
use App\Model\RoverCommand;
use App\Model\RoverDirection;
use Exception;

class RoverPositionFactory
{
    public function create(WorldInterface $world, int $x, int $y, string $direction): PositionInterface
    {
        if ($x < 0 || $x > $world->getWidth() || $y < 0 || $y > $world->getHeight()) {
            throw new Exception('Please position the rover inside the world');
        }

        return new RoverPosition($world, $x, $y, $direction);
    }

    public function createFromCoordinates(WorldInterface $world, string $roverData): PositionInterface
    {
        $trimmed = trim($roverData);
        preg_match(
            '/\[([0-9]+), *([0-9]+), *(['
                . implode('', RoverDirection::VALID_DIRECTIONS) . '])\] *['
                . implode('', RoverCommand::VALID_MOVEMENTS) . ']+/',
            $trimmed,
            $matches
        );

        if (count($matches) === 0) {
            throw new Exception('Invalid rover definition ('
            . $trimmed . '), please specify as i.e. "[3, 4, S] RRFFLRFFF"');
        }

        $x  = (int) $matches[1];
        $y = (int) $matches[2];
        $direction = $matches[3];

        return $this->create($world, $x, $y, $direction);
    }
}
