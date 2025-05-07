<?php

use Mettlive\SquareSolver\Commands\CheckFuelCommand;
use Mettlive\SquareSolver\Exceptions\NotEnoughFuelException;
use Mettlive\SquareSolver\IUsesFuel;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CheckFuelCommandTest extends MockeryTestCase
{
    public function testIsFuelEnough()
    {
        $obj = mock(IUsesFuel::class);

        $obj->expects('getFuelAmount')->andReturn(1.00);
        $obj->expects('getFuelConsumption')->andReturn(0.01);


        $checkFuelCommand = new CheckFuelCommand($obj);
        $checkFuelCommand->execute();

        $this->assertTrue(true);
    }

    public function testIsFuelIsNotEnough()
    {
        $obj = mock(IUsesFuel::class);

        $obj->expects('getFuelAmount')->andReturn(0.01);
        $obj->expects('getFuelConsumption')->andReturn(0.02);

        $this->expectException(NotEnoughFuelException::class);

        $checkFuelCommand = new CheckFuelCommand($obj);
        $checkFuelCommand->execute();

    }

    public function testIsFuelAmountIsCorrect()
    {
        $obj = mock(IUsesFuel::class);

        $obj->expects('getFuelAmount')->andReturn(null);

        $this->expectException(TypeError::class);

        $checkFuelCommand = new CheckFuelCommand($obj);
        $checkFuelCommand->execute();
    }

    public function testIsRequiredFuelIsCorrect()
    {
        $obj = mock(IUsesFuel::class);

        $obj->expects('getFuelAmount')->andReturn(0.01);
        $obj->expects('getFuelConsumption')->andReturn(null);

        $this->expectException(TypeError::class);

        $checkFuelCommand = new CheckFuelCommand($obj);
        $checkFuelCommand->execute();
    }
}