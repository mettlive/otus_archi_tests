<?php

namespace Mettlive\SquareSolver\Tests;

use Mettlive\SquareSolver\Commands\BurnFuelCommand;
use Mettlive\SquareSolver\IUsesFuel;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use TypeError;

class BurnFuelCommandTest extends MockeryTestCase
{
    public function testBurnFuel() {
        $obj = mock(IUsesFuel::class);

        $fuel = 1.00;
        $consumption = 0.01;

        $obj->expects('getFuelAmount')->andReturn($fuel);
        $obj->expects('getFuelConsumption')->andReturn($consumption);

        $obj->expects('setFuelAmount')->with($fuel-$consumption);

        $command = new BurnFuelCommand($obj);
        $command->execute();
    }

    public function testCannotGetFuelAmount() {
        $obj = mock(IUsesFuel::class);

        $fuel = 1.00;
        $consumption = 0.01;

        $obj->expects('getFuelAmount')->andReturn(null);


        $this->expectException(TypeError::class);

        $command = new BurnFuelCommand($obj);
        $command->execute();
    }

    public function testCannotGetFuelConsumption() {
        $obj = mock(IUsesFuel::class);

        $fuel = 1.00;

        $obj->expects('getFuelAmount')->andReturn($fuel);
        $obj->expects('getFuelConsumption')->andReturn(null);


        $this->expectException(TypeError::class);

        $command = new BurnFuelCommand($obj);
        $command->execute();

    }
}