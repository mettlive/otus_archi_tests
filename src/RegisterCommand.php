<?php

namespace Mettlive\SquareSolver;

use Closure;

class RegisterCommand implements ICommand
{

    public function __construct(
        private string $key,
        protected Closure $factory
    )
    {
    }

    public function execute()
    {
        IoC::registerDependency($this->key, $this->factory);
    }
}