<?php

declare(strict_types=1);
namespace Mettlive\SquareSolver;

use RuntimeException;

class IoC
{
    private static array $bindings = [];
    private static array $scopes = [];
    private static string $currentScope = 'default';

    public static function resolve(string $key, mixed ...$args): mixed
    {
        return match($key) {
            "IoC.Register" => new RegisterCommand($args[0], $args[1]),

            "Scopes.New" => new CreateScopeCommand($args[0]),
            "Scopes.Current" => new SetCurrentScopeCommand($args[0] ?? 'default'),

            default => self::resolveDependency($key, $args)
        };
    }

    private static function resolveDependency(string $key, array $args): mixed
    {
        $scope = self::$currentScope ?? 'default';

        if (!isset(self::$scopes[$scope])) {
            self::$scopes[$scope] = [];
        }

        if (isset(self::$scopes[$scope][$key])) {
            return (self::$scopes[$scope][$key])(...$args);
        }

        if (isset(self::$bindings[$key])) {
            return (self::$bindings[$key])(...$args);
        }

        throw new RuntimeException("Dependency not found: $key");
    }

    public static function registerDependency(string $key, callable $factory, ?string $scope = null): void
    {
        $targetScope = $scope ?? self::$currentScope ?? 'default';

        if ($targetScope === 'default') {
            self::$bindings[$key] = $factory;
        } else {
            if (!isset(self::$scopes[$targetScope])) {
                self::$scopes[$targetScope] = [];
            }
            self::$scopes[$targetScope][$key] = $factory;
        }
    }

    public static function setCurrentScope(?string $scopeId): void
    {
        self::$currentScope = $scopeId;
    }

    public static function createScope(string $scopeId): void
    {
        self::$scopes[$scopeId] = [];
    }

    public static function clear(): void
    {
        self::$bindings = [];
        self::$scopes = [];
        self::$currentScope = 'default';
    }
}
