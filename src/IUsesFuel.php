<?php

namespace Mettlive\SquareSolver;

interface IUsesFuel
{
    public function getFuelAmount(): float;
    public function getFuelConsumption(): float;
    public function setFuelAmount(float $amount): void;
}