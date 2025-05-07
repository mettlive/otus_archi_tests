<?php

use Mettlive\SquareSolver\Commands\MoveForwardWithBurnFuelCommand;
use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\IUsesFuel;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class MoveForwardWithBurnFuelCommandTest extends MockeryTestCase
{

    public function testConstructorAcceptsObjectWithBothInterfaces()
    {
        $validObject = Mockery::mock(IMovable::class . ', ' . IUsesFuel::class);
        $command = new MoveForwardWithBurnFuelCommand($validObject);

        $this->assertInstanceOf(MoveForwardWithBurnFuelCommand::class, $command);
    }

    public function testConstructorRejectsObjectWithOnlyIMovable() {
        $validObject = mock(IMovable::class);
        $this->expectException(TypeError::class);

        new MoveForwardWithBurnFuelCommand($validObject);
    }

    public function testConstructorRejectsObjectWithOnlyIUsesFuel() {
        $validObject = mock(IUsesFuel::class);
        $this->expectException(TypeError::class);

        new MoveForwardWithBurnFuelCommand($validObject);
    }

}