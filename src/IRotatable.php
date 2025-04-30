<?php

namespace Mettlive\SquareSolver;

interface IRotatable
{
    public function getAngle(): float;
    public function setAngle(float $angle): void;
    public function getAngularVelocity(): float;
}