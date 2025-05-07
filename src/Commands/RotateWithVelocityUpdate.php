<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\IRotatable;

class RotateWithVelocityUpdate implements ICommand
{

    public function __construct(protected IMovable & IRotatable $obj)
    {
    }

    public function execute()
    {
        $rotateCommand = new RotateCommand($this->obj);
        $changeSpeedCommand = new ChangeVelocityCommand($this->obj);

        $macroCommand = new MacroCommand(
            [
                $rotateCommand,
                $changeSpeedCommand
            ]
        );
        $macroCommand->execute();
    }
}