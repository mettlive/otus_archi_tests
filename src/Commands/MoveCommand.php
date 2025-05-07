<?php

namespace Mettlive\SquareSolver\Commands;

use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\Move;

class MoveCommand implements ICommand
{

    public function __construct(protected IMovable $IMovable)
    {
    }

    public function execute()
    {
        Move::execute($this->IMovable);
    }
}