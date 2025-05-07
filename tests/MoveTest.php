<?php

namespace Mettlive\SquareSolver\Tests;
use Mettlive\SquareSolver\IMovable;
use Mettlive\SquareSolver\Move;
use Mettlive\SquareSolver\VO\Point;
use Mettlive\SquareSolver\VO\Vector;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use TypeError;

class MoveTest extends TestCase
{
    public function testObjectMove() {
        $moveObject = mock(IMovable::class);

        $point = new Point(12, 5);
        $velocity = new Vector(-7, 3);

        $actualPoint = null;
        $expectedPoint = new Point(5,8);

        $moveObject->expects('getLocation')->andReturn($point);
        $moveObject->expects('getVelocity')->andReturn($velocity);

        $moveObject->expects('setLocation')->andReturnUsing(function($point) use (&$actualPoint) {
            $actualPoint = $point;
        });

        Move::execute($moveObject);

        $this->assertEquals($expectedPoint->x, $actualPoint->x);
        $this->assertEquals($expectedPoint->y, $actualPoint->y);
    }

    public function testThrowExceptionWhenPositionIsNotSet() {
        $moveObject = mock(IMovable::class);

        $moveObject->expects('getLocation')->andReturn(null);
        $moveObject->expects('getVelocity')->andReturn(new Vector(-7, 3));

        $this->expectException(TypeError::class);

        Move::execute($moveObject);
    }

    public function testThrowExceptionWhenVelocityIsNotSet() {
        $moveObject = mock(IMovable::class);

        $moveObject->expects('getLocation')->andReturn(new Point(12, 5));
        $moveObject->expects('getVelocity')->andReturn(null);

        $this->expectException(TypeError::class);

        Move::execute($moveObject);
    }

    public function testThrowExceptionWhenPositionIsCanNotBeSet() {
        $moveObject = mock(IMovable::class);

        $moveObject->expects('getLocation')->andReturn(new Point(12, 5));
        $moveObject->expects('getVelocity')->andReturn(new Vector(-7, 3));

        $moveObject->expects('setLocation')->andThrow(RuntimeException::class);

        $this->expectException(RuntimeException::class);

        Move::execute($moveObject);
    }
}