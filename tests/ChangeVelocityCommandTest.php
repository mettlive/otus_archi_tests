<?php

namespace Mettlive\SquareSolver\Tests;

use Mettlive\SquareSolver\Commands\ChangeVelocityCommand;
use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\IRotatable;
use Mettlive\SquareSolver\VO\Vector;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ChangeVelocityCommandTest extends MockeryTestCase
{
    #[DataProvider('angleVelocityProvider')]
    public function testExecuteChangesVelocityCorrectly(float $initialAngle, Vector $initialVelocity, Vector $expectedVelocity)
    {

        $mockObject = Mockery::mock(IMovable::class . ',' . IRotatable::class);

        $mockObject->expects('getAngle')
            ->once()
            ->andReturn($initialAngle);

        $mockObject->expects('getVelocity')
            ->once()
            ->andReturn($initialVelocity);

        $mockObject->expects('setVelocity')
            ->once()
            ->withArgs(function(Vector $vector) use ($expectedVelocity) {
                return abs($vector->x - $expectedVelocity->x) < 0.0001 &&
                    abs($vector->y - $expectedVelocity->y) < 0.0001;
            });

        $command = new ChangeVelocityCommand($mockObject);

        $command->execute();
    }

    public static function angleVelocityProvider(): array
    {
        return [
            'Angle 0 degrees' => [
                0,
                new Vector(5, 0),
                new Vector(5, 0)
            ],
            'Angle 90 degrees' => [
                90,
                new Vector(5, 0),
                new Vector(0, 5)
            ],
            'Angle 180 degrees' => [
                180,
                new Vector(5, 0),
                new Vector(-5, 0)
            ],
            'Angle 270 degrees' => [
                270,
                new Vector(5, 0),
                new Vector(0, -5)
            ],
            'Angle 45 degrees' => [
                45,
                new Vector(sqrt(2), 0),
                new Vector(1, 1)
            ],
        ];
    }

    public function testMaintainsSpeedMagnitude()
    {
        $initialVelocity = new Vector(3, 4); // speed = 5
        $angle = 60;

        $mockObject = Mockery::mock(IMovable::class . ',' . IRotatable::class);

        $mockObject->expects('getAngle')
            ->once()
            ->andReturn($angle);

        $mockObject->expects('getVelocity')
            ->once()
            ->andReturn($initialVelocity);

        $mockObject->expects('setVelocity')
            ->once()
            ->withArgs(function(Vector $vector) {
                $speed = sqrt($vector->x * $vector->x + $vector->y * $vector->y);
                return abs($speed - 5) < 0.0001;
            });

        $command = new ChangeVelocityCommand($mockObject);

        $command->execute();

    }

    public function testConstructorRequiresCorrectInterface()
    {
        $mockMovableOnly = Mockery::mock(IMovable::class);

        $this->expectException(\TypeError::class);

        new ChangeVelocityCommand($mockMovableOnly);
    }
}