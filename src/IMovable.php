<?php

namespace Mettlive\SquareSolver;

use Mettlive\SquareSolver\VO\Point;
use Mettlive\SquareSolver\VO\Vector;

interface IMovable
{
    public function getLocation(): Point;
    public function setLocation(Point $location): void;
    public function getVelocity(): Vector;
    public function setVelocity(Vector $vector): void;
}