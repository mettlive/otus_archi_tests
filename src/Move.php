<?php

namespace Mettlive\SquareSolver;

use Mettlive\SquareSolver\VO\Point;

class Move
{

    public static function execute(IMovable $movableObject): void
    {
        $movableObject->setLocation(new Point(
                $movableObject->getVelocity()->x + $movableObject->getLocation()->x,
                $movableObject->getVelocity()->y + $movableObject->getLocation()->y,
        )
        );
    }

}