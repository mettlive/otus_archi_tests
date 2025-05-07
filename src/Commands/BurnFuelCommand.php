<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IUsesFuel;

class BurnFuelCommand implements ICommand
{

    public function __construct(protected IUsesFuel $obj)
    {
    }

    public function execute()
    {
        $fuel = $this->obj->getFuelAmount();
        $consumption = $this->obj->getFuelConsumption();

        $this->obj->setFuelAmount($fuel-$consumption);
    }
}