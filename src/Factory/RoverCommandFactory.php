<?php

namespace App\Factory;

use App\Entity\RoverCommand;
use App\Interface\CommandInterface;
use App\Model\RoverCommand as ModelRoverCommand;
use App\Model\RoverDirection;
use Exception;

class RoverCommandFactory
{
    public function create(array $commands): CommandInterface
    {
        return new RoverCommand($commands);
    }

    public function createFromCoordinates(string $roverData): CommandInterface
    {
        $trimmed = trim($roverData);
        preg_match(
            '/\[[0-9]+, *[0-9]+, *['
                . implode('', RoverDirection::VALID_DIRECTIONS) . ']\] *(['
                . implode('', ModelRoverCommand::VALID_MOVEMENTS) . ']+)/',
            $trimmed,
            $matches
        );

        if (count($matches) === 0) {
            throw new Exception('Invalid rover definition('
                . $trimmed . '), please specify as i.e. "[3, 4, S] RRFFLRFFF"');
        }

        $commands = mb_str_split($matches[1]);

        return $this->create($commands);
    }
}
