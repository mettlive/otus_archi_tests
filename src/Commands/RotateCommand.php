<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IRotatable;
use Mettlive\SquareSolver\Rotate;

class RotateCommand implements ICommand
{

    public function __construct(protected IRotatable $obj)
    {
    }

    public function execute()
    {
        Rotate::execute($this->obj);
    }
}