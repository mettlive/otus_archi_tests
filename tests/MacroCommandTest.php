<?php

namespace Mettlive\SquareSolver\Tests;

use InvalidArgumentException;
use Mettlive\SquareSolver\Commands\ICommand;
use Mettlive\SquareSolver\Commands\MacroCommand;
use Mettlive\SquareSolver\Exceptions\CommandException;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class MacroCommandTest extends MockeryTestCase
{

    public function testItAcceptOnlyCommand()
    {
        $array = [1,2,3,4,5];

        $this->expectException(InvalidArgumentException::class);

        new MacroCommand($array);
    }

    public function testItThrowExceptionWhenCommandIsNotAvailable()
    {
        $command1 = mock(ICommand::class);
        $command1->expects('execute')->andThrow(new CommandException("Exception"));

        $this->expectException(CommandException::class);

        $macroCommand = new MacroCommand([$command1]);
        $macroCommand->execute();
    }

    public function testMacroCommandWithCommands() {
        $command1 = mock(ICommand::class);
        $command1->expects('execute')->once();

        $command2 = mock(ICommand::class);
        $command2->expects('execute')->once();

        $command3 = mock(ICommand::class);
        $command3->expects('execute')->once();

        $array = [
            $command1,
            $command2,
            $command3
        ];

        $macroCommand = new MacroCommand($array);
        $macroCommand->execute();

    }

}