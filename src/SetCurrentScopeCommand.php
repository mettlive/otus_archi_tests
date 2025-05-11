<?php

namespace Mettlive\SquareSolver;

class SetCurrentScopeCommand implements ICommand
{

    public function __construct(
        protected string $scopeId
    )
    {
    }

    public function execute()
    {
        IoC::setCurrentScope($this->scopeId);
    }
}