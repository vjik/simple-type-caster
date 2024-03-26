<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use Stringable;
use Yiisoft\Strings\NumericHelper;

use function is_array;
use function is_float;
use function is_int;

class TypeCaster
{
    final public static function toIntOrNull(mixed $value, ?int $min = null, ?int $max = null): ?int
    {
        if (!is_scalar($value) && !$value instanceof Stringable) {
            return null;
        }

        if (!is_int($value)) {
            $value = self::toStringOrNull(NumericHelper::normalize($value));
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

        $value = self::toStringOrNull(NumericHelper::normalize($value));
        return $value === null ? null : (float) $value;
    }

    final public static function toString(mixed $value): string
    {
        if (is_array($value)) {
            return '';
        }

        $value = (string) $value;
        return trim($value);
    }

    /**
     * @psalm-return non-empty-string|null
     */
    final public static function toStringOrNull(mixed $value): ?string
    {
        if (is_array($value)) {
            return null;
        }

        $value = trim((string) $value);
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
}
