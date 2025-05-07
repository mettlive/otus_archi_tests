<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\IRotatable;
use Mettlive\SquareSolver\VO\Vector;

class ChangeVelocityCommand implements ICommand
{

    public function __construct(protected IMovable & IRotatable $obj)
    {
    }

    public function execute()
    {
        $velocity = $this->obj->getVelocity();
        $speed = sqrt($velocity->x * $velocity->x + $velocity->y * $velocity->y);

        $angle = $this->obj->getAngle();
        $newVelocityX = $speed * cos(deg2rad($angle));
        $newVelocityY = $speed * sin(deg2rad($angle));

        $this->obj->setVelocity(new Vector($newVelocityX, $newVelocityY));
    }
}