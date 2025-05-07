<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\IUsesFuel;

class MoveForwardWithBurnFuelCommand implements ICommand
{

    public function __construct(protected IMovable & IUsesFuel $obj)
    {
    }

    public function execute()
    {
        $checkFuelCommand = new CheckFuelCommand($this->obj);
        $moveCommand = new MoveCommand($this->obj);
        $burnFuelCommand = new BurnFuelCommand($this->obj);

        $macroCommand = new MacroCommand([
            $checkFuelCommand,
            $moveCommand,
            $burnFuelCommand
        ]);

        $macroCommand->execute();

    }
}