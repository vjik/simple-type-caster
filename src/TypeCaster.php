<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster;

final class TypeCaster
{
    /**
     * @param mixed $value
     * @return int|null
     */
    public static function toIntOrNull($value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        $value = self::toStringOrNull($value);
        return $value === null ? null : (int)$value;
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    public static function toStringOrNull($value): ?string
    {
        $value = (string)$value;
        $value = trim($value);
        return $value === '' ? null : $value;
    }

    /**
     * @param mixed $value
     * @return array
     */
    public static function toArray($value): array
    {
        return is_array($value) ? $value : [];
    }
}
