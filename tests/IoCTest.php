<?php

namespace Mettlive\SquareSolver\Tests;

use Mettlive\SquareSolver\IoC;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;

class IoCTest extends TestCase
{
    protected function setUp(): void
    {
        IoC::clear();
    }

    public function testBasicDependencyResolution(): void
    {
        $dependency = new stdClass();
        IoC::resolve("IoC.Register", "test", fn() => $dependency)->execute();

        $result = IoC::resolve("test");

        $this->assertSame($dependency, $result);
    }

    public function testScopedDependencyResolution(): void
    {
        $defaultDependency = new stdClass();
        $scopedDependency = new stdClass();

        IoC::resolve("IoC.Register", "test", fn() => $defaultDependency)->execute();

        IoC::resolve("Scopes.New", "testScope")->execute();
        IoC::resolve("Scopes.Current", "testScope")->execute();
        IoC::resolve("IoC.Register", "test", fn() => $scopedDependency)->execute();

        $scopedResult = IoC::resolve("test");

        IoC::resolve("Scopes.Current", 'default')->execute();
        $defaultResult = IoC::resolve("test");

        $this->assertSame($scopedDependency, $scopedResult);
        $this->assertSame($defaultDependency, $defaultResult);
    }

    public function testDependencyWithParameters(): void
    {
        IoC::resolve("IoC.Register", "test", static fn($param) => $param)->execute();

        $result = IoC::resolve("test", "parameter");

        $this->assertEquals("parameter", $result);
    }

    public function testMissingDependency(): void
    {
        $this->expectException(RuntimeException::class);
        IoC::resolve("nonexistent");
    }
}