<?php

namespace Mettlive\SquareSolver;

use InvalidArgumentException;

class QuadraticEquationSolver
{

    public function solve(float $a, float $b, float $c, float $e = 1.0e-6): array {
        if (!is_finite($a) || !is_finite($b) || !is_finite($c)) {
            throw new InvalidArgumentException("Коэффициенты должны быть конечными числами");
        }

        if (is_nan($a) || is_nan($b) || is_nan($c)) {
            throw new InvalidArgumentException("Коэффициенты не могут быть NaN");
        }

        if (abs($a) <= $e) {
            throw new InvalidArgumentException("a не может быть 0");
        }

        $discriminant = ($b * $b) - (4 * $a * $c);

        if ($discriminant < -$e) {
            return [];
        }

        if (abs($discriminant) < $e) {
            $x = -$b/(2*$a);
            return [$x,$x];
        }

        $x1 = (-$b + sqrt($discriminant)) / (2 * $a);
        $x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        return [$x1, $x2];
    }

}