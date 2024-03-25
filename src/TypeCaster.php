<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use Stringable;
use Yiisoft\Strings\NumericHelper;

use function is_array;
use function is_float;
use function is_int;

final class TypeCaster
{
    public static function toIntOrNull(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        if (!is_scalar($value) && !$value instanceof Stringable) {
            return null;
        }

        $value = self::toStringOrNull(NumericHelper::normalize($value));
        return $value === null ? null : (int) $value;
    }

    /**
     * @psalm-return non-negative-int|null
     */
    public static function toNonNegativeIntOrNull(mixed $value): ?int
    {
        $value = self::toIntOrNull($value);
        return ($value === null || $value < 0) ? null : $value;
    }

    public static function toFloatOrNull(mixed $value): ?float
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

    public static function toString(mixed $value): string
    {
        if (is_array($value)) {
            return '';
        }

        $value = (string) $value;
        return trim($value);
    }

    public static function toStringOrNull(mixed $value): ?string
    {
        if (is_array($value)) {
            return null;
        }

        $value = (string) $value;
        $value = trim($value);
        return $value === '' ? null : $value;
    }

    public static function toArray(mixed $value): array
    {
        return is_array($value) ? $value : [];
    }

    public static function toArrayOrNull(mixed $value): ?array
    {
        return is_array($value) ? $value : null;
    }
}
