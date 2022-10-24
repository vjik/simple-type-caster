<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

use InvalidArgumentException;
use Yiisoft\Strings\NumericHelper;

use function is_array;
use function is_float;
use function is_int;

final class TypeCaster
{
    /**
     * @param mixed $value
     */
    public static function toIntOrNull($value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        try {
            /** @psalm-suppress MixedArgument */
            $value = NumericHelper::normalize($value);
        } catch (InvalidArgumentException $e) {
            return null;
        }

        $value = self::toStringOrNull($value);
        return $value === null ? null : (int)$value;
    }

    /**
     * @param mixed $value
     */
    public static function toFloatOrNull($value): ?float
    {
        if (is_float($value)) {
            return $value;
        }

        try {
            /** @psalm-suppress MixedArgument */
            $value = NumericHelper::normalize($value);
        } catch (InvalidArgumentException $e) {
            return null;
        }

        $value = self::toStringOrNull($value);
        return $value === null ? null : (float)$value;
    }

    /**
     * @param mixed $value
     */
    public static function toStringOrNull($value): ?string
    {
        if (is_array($value)) {
            return null;
        }

        $value = (string)$value;
        $value = trim($value);
        return $value === '' ? null : $value;
    }

    /**
     * @param mixed $value
     */
    public static function toArray($value): array
    {
        return is_array($value) ? $value : [];
    }

    /**
     * @param mixed $value
     */
    public static function toArrayOrNull($value): ?array
    {
        return is_array($value) ? $value : null;
    }
}
