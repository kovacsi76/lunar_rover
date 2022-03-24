<?php

namespace App\Entity;

use App\Interface\CommandInterface;

class RoverCommand implements CommandInterface
{
    public function __construct(protected array $commands) {}

    public function getCommands(): array
    {
        return $this->commands;
    }
}
