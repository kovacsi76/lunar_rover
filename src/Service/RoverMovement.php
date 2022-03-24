<?php

namespace App\Service;

use App\Exception\VehicleLostException;
use App\Interface\VehicleInterface;
use App\Model\RoverCommand;
use App\Model\RoverDirection;
use App\Model\RoverMovement as ModelRoverMovement;
use Exception;

class RoverMovement
{
    public function executeVehicleCommands(VehicleInterface $vehicle): void
    {
        $location = $vehicle->getPosition();
        $commands = $vehicle->getCommand()->getCommands();
        foreach ($commands as $command) {
            switch ($command) {
                case RoverCommand::LEFT:
                    $curDir = $location->getDirection();
                    $newDir = ModelRoverMovement::LEFT[$curDir] ?? null;
                    if ($newDir === null) {
                        throw new Exception(
                            'New direction not found for turning left from direction (' . $curDir . ')'
                        );
                    }
                    $location->setDirection($newDir);
                    break;
                case RoverCommand::RIGHT:
                    $curDir = $location->getDirection();
                    $newDir = ModelRoverMovement::RIGHT[$curDir] ?? null;
                    if ($newDir === null) {
                        throw new Exception(
                            'New direction not found for turning right from direction (' . $curDir . ')'
                        );
                    }
                    $location->setDirection($newDir);
                    break;
                case RoverCommand::FORWARD:
                    $curDir = $location->getDirection();
                    $newMove = ModelRoverMovement::FORWARD[$curDir] ?? null;
                    if ($newMove === null) {
                        throw new Exception('Forward movement not found for direction (' . $curDir . ')');
                    }
                    try {
                        if (in_array($curDir, RoverDirection::X_AXIS)) {
                            $x = $location->getPositionX();
                            $location->setPositionX($x + $newMove);
                        } elseif (in_array($curDir, RoverDirection::Y_AXIS)) {
                            $y = $location->getPositionY();
                            $location->setPositionY($y + $newMove);
                        }
                    } catch (VehicleLostException $e) {
                        break 2;
                    }
                    break;
                default:
                    throw new Exception('Command not found (' . $command . ')');
            }
        }
    }
}
