<?php

namespace Mettlive\SquareSolver;

class Rotate
{

    public static function execute(IRotatable $object) {
        $newAngle = $object->getAngle() + $object->getAngularVelocity();
        $newAngle = fmod($newAngle, 360);
        $object->setAngle($newAngle);
    }

}