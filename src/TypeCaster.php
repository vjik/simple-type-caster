<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use BackedEnum;
use DateTimeImmutable;
use Stringable;
use Yiisoft\Strings\NumericHelper;

use function is_array;
use function is_float;
use function is_int;
use function is_scalar;
use function is_string;

/**
 * @api
 */
class TypeCaster
{
    final public static function toInt(mixed $value, ?int $min = null, ?int $max = null, int $default = 0): int
    {
        if (!is_int($value)) {
            if (is_scalar($value) || $value instanceof Stringable) {
                $value = NumericHelper::normalize($value);
                if ($value === '') {
                    return $default;
                }
                $value = (int) $value;
            } else {
                return $default;
            }
        }

        if ($min !== null && $value < $min) {
            return $default;
        }

        if ($max !== null && $value > $max) {
            return $default;
        }

        return $value;
    }

    final public static function toIntOrNull(mixed $value, ?int $min = null, ?int $max = null): ?int
    {
        if (!is_int($value)) {
            if (is_scalar($value) || $value instanceof Stringable) {
                $value = NumericHelper::normalize($value);
                if ($value === '') {
                    return null;
                }
                $value = (int) $value;
            } else {
                return null;
            }
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

        $value = self::toStringOrNull(NumericHelper::normalize($value));
        return $value === null ? null : (float) $value;
    }

    final public static function toPositiveFloatOrNull(mixed $value): ?float
    {
        $value = self::toFloatOrNull($value);
        return $value !== null && $value > 0 ? $value : null;
    }

    final public static function toString(mixed $value, bool $trim = false): string
    {
        if (!is_scalar($value) && !$value instanceof Stringable) {
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
        if (!is_scalar($value) && !$value instanceof Stringable) {
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
     * @return BackedEnum[]
     *
     * @psalm-template TClass as BackedEnum
     * @psalm-param class-string<TClass> $class
     * @psalm-return list<TClass>
     */
    final public static function toListOfBackedEnums(string $class, mixed $value): array
    {
        $result = [];
        $isStringEnum = BackedEnumTypeChecker::isString($class);
        foreach (self::toArray($value) as $item) {
            if ($item instanceof $class) {
                $result[] = $item;
            } elseif (
                ($isStringEnum && is_string($item)) ||
                (!$isStringEnum && is_int($item))
            ) {
                /** @var string|int $item */
                $enum = $class::tryFrom($item);
                if ($enum !== null) {
                    $result[] = $enum;
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

    /**
     * @param mixed $value
     * @return string[]
     * @psalm-return list<non-empty-string>
     */
    final public static function toListOfNonEmptyStrings(mixed $value, bool $trim = false): array
    {
        $result = [];
        foreach (self::toArray($value) as $item) {
            $item = self::toStringOrNull($item, $trim);
            if ($item !== null) {
                $result[] = $item;
            }
        }
        return $result;
    }

    final public static function toDateTimeOrNullByTimestamp(mixed $value): DateTimeImmutable|null
    {
        $timestamp = self::toIntOrNull($value);
        return $timestamp === null ? null : (new DateTimeImmutable())->setTimestamp($timestamp);
    }
}
