<?php

namespace App\Factory;

use App\Entity\RoverVehicle;
use App\Interface\VehicleInterface;
use App\Interface\WorldInterface;
use App\Model\RoverCommand;
use App\Model\RoverDirection;
use Exception;

class RoverFactory
{
    public function __construct(
        protected RoverPositionFactory $positionFactory,
        protected RoverCommandFactory $commandFactory
    ) {}

    public function create(
        WorldInterface $world,
        int $x,
        int $y,
        string $direction,
        array $commands
    ): VehicleInterface {
        $position = $this->positionFactory->create($world, $x, $y, $direction);
        $command = $this->commandFactory->create($commands);

        return new RoverVehicle($world, $position, $command);
    }

    public function createFromData(WorldInterface $world, string $roverData): VehicleInterface
    {
        $trimmed = trim($roverData);
        preg_match(
            '/\[([0-9]+), *([0-9]+), *(['
                . implode('', RoverDirection::VALID_DIRECTIONS) . '])\] *(['
                . implode('', RoverCommand::VALID_MOVEMENTS) . ']+)/',
            $trimmed,
            $matches
        );

        if (count($matches) === 0) {
            throw new Exception('Invalid rover definition ('
                . $trimmed . '), please specify as i.e. "[3, 4, S] RRFFLRFFF"');
        }

        $x = $matches[1];
        $y = $matches[2];
        $direction = $matches[3];
        $commands = mb_str_split($matches[4]);

        return $this->create($world, $x, $y, $direction, $commands);
    }
}
