<?php

use Mettlive\SquareSolver\QuadraticEquationSolver;
use PHPUnit\Framework\TestCase;

class QuadraticEquationSolverTest extends TestCase
{
    protected QuadraticEquationSolver $solver;
    public function setUp(): void
    {
        $this->solver = new QuadraticEquationSolver();
    }

    public function testNoRealRootsEquation()
    {
        // Arrange
        $a = 1;
        $b = 0;
        $c = 1;

        // Act
        $roots = $this->solver->solve($a, $b, $c);

        // Assert
        $this->assertIsArray($roots);
        $this->assertEmpty($roots);
    }

    public function testTwoDistinctRealRoots()
    {
        // Arrange
        $a = 1;
        $b = 0;
        $c = -1;

        // Act
        $roots = $this->solver->solve($a, $b, $c);

        // Assert
        $this->assertIsArray($roots);
        $this->assertCount(2, $roots);
        $this->assertContains(1.0, $roots);
        $this->assertContains(-1.0, $roots);
    }

    public function testOneDistinctRealRoots()
    {
        // Arrange
        $a = 1;
        $b = 0;
        $c = -1;

        // Act
        $roots = $this->solver->solve($a, $b, $c);

        // Assert
        $this->assertIsArray($roots);
        $this->assertCount(2, $roots);
        $this->assertContains(1.0, $roots);
        $this->assertContains(-1.0, $roots);
    }

    public function testOneDoubleRoot()
    {
        // Arrange
        $a = 1;
        $b = 2;
        $c = 1;

        // Act
        $roots = $this->solver->solve($a, $b, $c);

        // Assert
        $this->assertIsArray($roots);
        $this->assertCount(2, $roots);
        $this->assertEqualsWithDelta(-1, $roots[0], 0.0001);
        $this->assertEqualsWithDelta(-1, $roots[1], 0.0001);
    }

    public function testThrowExceptionWhenAIsZero() {
        $a = 0;
        $b = 1;
        $c = 1;

        // Assert & Act
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("a не может быть 0");

        $this->solver->solve($a, $b, $c);
    }

    public function testOneDoubleRootWithNearZeroDiscriminant()
    {
        // Arrange
        $a = 1.0;
        $b = 2.0;
        $c = 1.0 + 1e-12;

        // Act
        $roots = $this->solver->solve($a, $b, $c);

        // Assert
        $this->assertIsArray($roots);
        $this->assertCount(2, $roots);
        $this->assertEqualsWithDelta(-1, $roots[0], 0.0001);
        $this->assertEqualsWithDelta(-1, $roots[1], 0.0001);
    }

    public function testSpecialDoubleValues()
    {

        $specialValues = [
            INF,
            -INF,
            NAN,
        ];

        foreach ($specialValues as $value) {
            $this->expectException(InvalidArgumentException::class);
            $this->solver->solve($value, 1, 1);

            $this->expectException(InvalidArgumentException::class);
            $this->solver->solve(1, $value, 1);

            $this->expectException(InvalidArgumentException::class);
            $this->solver->solve(1, 1, $value);
        }
    }

}