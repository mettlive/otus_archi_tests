<?php

use Mettlive\SquareSolver\IRotatable;
use Mettlive\SquareSolver\Rotate;
use PHPUnit\Framework\TestCase;

class RotateTest extends TestCase
{
    public function testObjectRotate() {
        $rotatableObject = mock(IRotatable::class);

        $initialAngle = 45.0;
        $angularVelocity = 30.0;
        $expectedAngle = 75.0;

        $rotatableObject->expects('getAngle')->andReturn($initialAngle);
        $rotatableObject->expects('getAngularVelocity')->andReturn($angularVelocity);
        $rotatableObject->shouldReceive('setAngle')->once()->with($expectedAngle);

        Rotate::execute($rotatableObject);

        $this->assertTrue(true);
    }

    public function testThrowExceptionWhenAngleIsNotSet()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(null);
        $rotateObject->expects('getAngularVelocity')->andReturn(30.0);

        $this->expectException(TypeError::class);

        Rotate::execute($rotateObject);
    }

    public function testThrowExceptionWhenAngularVelocityIsNotSet()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(45.0);
        $rotateObject->expects('getAngularVelocity')->andReturn(null);

        $this->expectException(TypeError::class);

        Rotate::execute($rotateObject);
    }

    public function testThrowExceptionWhenAngleCanNotBeSet()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(45.0);
        $rotateObject->expects('getAngularVelocity')->andReturn(30.0);

        $rotateObject->expects('setAngle')->andThrow(RuntimeException::class);

        $this->expectException(RuntimeException::class);

        Rotate::execute($rotateObject);
    }

    public function testHandleNegativeAngle()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(-45.0);
        $rotateObject->expects('getAngularVelocity')->andReturn(30.0);
        $rotateObject->expects('setAngle')->with(-15.0);

        Rotate::execute($rotateObject);

        $this->assertTrue(true);
    }

    public function testHandleAngleOverflow()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(350.0);
        $rotateObject->expects('getAngularVelocity')->andReturn(30.0);
        $rotateObject->expects('setAngle')->with(20.0);

        Rotate::execute($rotateObject);

        $this->assertTrue(true);
    }

    public function testHandleZeroAngularVelocity()
    {
        $rotateObject = mock(IRotatable::class);

        $initialAngle = 45.0;
        $rotateObject->expects('getAngle')->andReturn($initialAngle);
        $rotateObject->expects('getAngularVelocity')->andReturn(0.0);
        $rotateObject->expects('setAngle')->with($initialAngle);

        Rotate::execute($rotateObject);

        $this->assertTrue(true);
    }

    public function testHandleExtremelyLargeAngularVelocity()
    {
        $rotateObject = mock(IRotatable::class);

        $rotateObject->expects('getAngle')->andReturn(0.0);
        $rotateObject->expects('getAngularVelocity')->andReturn(720.0);
        $rotateObject->expects('setAngle')->with(0.0);

        Rotate::execute($rotateObject);

        $this->assertTrue(true);
    }
}