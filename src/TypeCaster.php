<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use BackedEnum;
use Stringable;
use Yiisoft\Strings\NumericHelper;

use function is_array;
use function is_float;
use function is_int;
use function is_string;

/**
 * @api
 */
class TypeCaster
{
    final public static function toIntOrNull(mixed $value, ?int $min = null, ?int $max = null): ?int
    {
        if (!is_scalar($value) && !$value instanceof Stringable) {
            return null;
        }

        if (!is_int($value)) {
            $value = self::toStringOrNull(NumericHelper::normalize($value), trim: true);
            if ($value === null) {
                return null;
            }
            $value = (int) $value;
        }

        if ($min !== null && $value < $min) {
            return null;
        }

        if ($max !== null && $value > $max) {
            return null;
        }

        return $value;
    }

    /**
     * @psalm-return non-negative-int|null
     */
    final public static function toNonNegativeIntOrNull(mixed $value): ?int
    {
        /** @var non-negative-int|null */
        return self::toIntOrNull($value, min: 0);
    }

    /**
     * @psalm-return positive-int|null
     */
    final public static function toPositiveIntOrNull(mixed $value): ?int
    {
        /** @var positive-int|null */
        return self::toIntOrNull($value, min: 1);
    }

    final public static function toFloatOrNull(mixed $value): ?float
    {
        if (is_float($value)) {
            return $value;
        }

        if (!is_scalar($value) && !$value instanceof Stringable) {
            return null;
        }

        $value = self::toStringOrNull(NumericHelper::normalize($value), trim: true);
        return $value === null ? null : (float) $value;
    }

    final public static function toString(mixed $value, bool $trim = false): string
    {
        if (is_array($value)) {
            return '';
        }

        $value = (string) $value;

        return $trim ? trim($value) : $value;
    }

    /**
     * @psalm-return non-empty-string|null
     */
    final public static function toStringOrNull(mixed $value, bool $trim = false): ?string
    {
        if (is_array($value)) {
            return null;
        }

        $value = (string) $value;
        if ($trim) {
            $value = trim($value);
        }

        return $value === '' ? null : $value;
    }

    final public static function toArray(mixed $value): array
    {
        return is_array($value) ? $value : [];
    }

    final public static function toArrayOrNull(mixed $value): ?array
    {
        return is_array($value) ? $value : null;
    }

    /**
     * @return BackedEnum[]
     *
     * @psalm-template TClass as BackedEnum
     * @psalm-param class-string<TClass> $class
     * @psalm-return array<array-key,TClass>
     */
    final public static function toArrayOfBackedEnums(string $class, mixed $value): array
    {
        $result = [];
        $isStringEnum = BackedEnumTypeChecker::isString($class);
        foreach (self::toArray($value) as $key => $item) {
            if ($item instanceof $class) {
                $result[$key] = $item;
            } elseif (
                ($isStringEnum && is_string($item)) ||
                (!$isStringEnum && is_int($item))
            ) {
                /** @var string|int $item */
                $enum = $class::tryFrom($item);
                if ($enum !== null) {
                    $result[$key] = $enum;
                }
            }
        }
        return $result;
    }

    /**
     * @psalm-template TClass as BackedEnum
     * @psalm-param class-string<TClass> $class
     * @psalm-return TClass|null
     */
    final public static function toBackedEnumOrNull(string $class, mixed $value): ?BackedEnum
    {
        if ($value instanceof $class) {
            return $value;
        }

        $isStringValue = is_string($value);
        if (!$isStringValue && !is_int($value)) {
            return null;
        }
        /** @var string|int $value */

        if (BackedEnumTypeChecker::isString($class) !== $isStringValue) {
            return null;
        }

        return $class::tryFrom($value);
    }
}
