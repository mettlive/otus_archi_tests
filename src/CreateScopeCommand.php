<?php

namespace Mettlive\SquareSolver;

class CreateScopeCommand implements ICommand
{

    public function __construct(
        protected string $scopeId
    )
    {
    }

    public function execute()
    {
        IoC::createScope($this->scopeId);
    }
}