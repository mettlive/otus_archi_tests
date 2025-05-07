<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\Exceptions\NotEnoughFuelException;
use Mettlive\SquareSolver\IUsesFuel;

class CheckFuelCommand implements ICommand
{

    public function __construct(protected IUsesFuel $object)
    {
    }

    public function execute()
    {
        $fuel = $this->object->getFuelAmount();
        $consumption = $this->object->getFuelConsumption();

        if ($fuel < $consumption) {
            throw new NotEnoughFuelException("Недостаточно топлива для движения");
        }
    }
}