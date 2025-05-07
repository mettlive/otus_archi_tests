<?php

namespace Mettlive\SquareSolver\Commands;

use Exception;
use Mettlive\SquareSolver\Exceptions\CommandException;

class MacroCommand
{

    public function __construct(protected array $commands)
    {
        foreach ($this->commands as $command) {
            if (!$command instanceof ICommand) {
                throw new \InvalidArgumentException("В макрокоманду могут быть добавлены только команды");
            }
        }
    }

    public function execute()
    {
        /** @var ICommand $command */
        foreach ($this->commands as $command) {
            try {
                $command->execute();
            } catch (Exception $e) {
                throw new CommandException($e->getMessage());
            }

        }
    }
}