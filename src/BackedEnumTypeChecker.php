<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use BackedEnum;
use ReflectionEnum;
use ReflectionNamedType;

/**
 * @internal
 */
final class BackedEnumTypeChecker
{
    /**
     * @psalm-var array<class-string<BackedEnum>, bool>
     */
    private static array $cache = [];

    /**
     * @psalm-param class-string<BackedEnum> $class
     */
    public static function isString(string $class): bool
    {
        if (isset(self::$cache[$class])) {
            return self::$cache[$class];
        }

        $reflection = new ReflectionEnum($class);

        /**
         * @var ReflectionNamedType $type
         */
        $type = $reflection->getBackingType();

        self::$cache[$class] = $type->getName() === 'string';

        return self::$cache[$class];
    }
}
