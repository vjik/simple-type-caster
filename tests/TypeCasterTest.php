<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\SimpleTypeCaster\TypeCaster;

final class TypeCasterTest extends TestCase
{
    public static function dataToIntOrNull(): array
    {
        return [
            ['12 000', 12000],
            [42, 42],
            ['42', 42],
            [0, 0],
            ['0', 0],
            ['', null],
            [null, null],
            [new stdClass(), null],
            [-1, -1],
            ['-1', -1],
        ];
    }

    #[DataProvider('dataToIntOrNull')]
    public function testToIntOrNull(mixed $value, ?int $expected): void
    {
        self::assertSame($expected, TypeCaster::toIntOrNull($value));
    }

    public static function dataToNonNegativeIntOrNull(): array
    {
        return [
            ['12 000', 12000],
            [42, 42],
            ['42', 42],
            [0, 0],
            ['0', 0],
            ['', null],
            [null, null],
            [new stdClass(), null],
            [-1, null],
            ['-1', null],
        ];
    }

    #[DataProvider('dataToNonNegativeIntOrNull')]
    public function testToNonNegativeIntOrNull(mixed $value, ?int $expected): void
    {
        self::assertSame($expected, TypeCaster::toNonNegativeIntOrNull($value));
    }

    public static function dataToFloatOrNull(): array
    {
        return [
            ['12 500,90', 12500.9],
            ['13.56', 13.56],
            [13.56, 13.56],
            [1, 1.0],
            [0, 0.0],
            ['0', 0.0],
            ['', null],
            [null, null],
            [new stdClass(), null],
            [[], null],
            [['a'], null],
        ];
    }

    #[DataProvider('dataToFloatOrNull')]
    public function testToFloatOrNull(mixed $value, ?float $expected): void
    {
        self::assertSame($expected, TypeCaster::toFloatOrNull($value));
    }

    public static function dataToString(): array
    {
        return [
            ['hello', 'hello'],
            ['0', '0'],
            [12, '12'],
            [4.5, '4.5'],
            [true, '1'],
            [false, ''],
            ['', ''],
            [null, ''],
            [[], ''],
            [['a'], ''],
            ['  hello  ', 'hello'],
        ];
    }

    #[DataProvider('dataToString')]
    public function testToString(mixed $value, string $expected): void
    {
        self::assertSame($expected, TypeCaster::toString($value));
    }

    public static function dataToStringOrNull(): array
    {
        return [
            ['hello', 'hello'],
            ['0', '0'],
            ['', ''],
            [' test ', ' test '],
            ['  ', '  '],
            [null, null],
            [25, '25'],
            [[], null],
            [['a'], null],
        ];
    }

    #[DataProvider('dataToStringOrNull')]
    public function testToStringOrNull(mixed $value, ?string $expected): void
    {
        self::assertSame($expected, TypeCaster::toStringOrNull($value));
    }

    public static function dataNonEmptyToStringOrNull(): array
    {
        return [
            ['hello', 'hello'],
            ['0', '0'],
            ['', null],
            [' test ', 'test'],
            ['  ', null],
            [null, null],
            [25, '25'],
            [[], null],
            [['a'], null],
        ];
    }

    #[DataProvider('dataNonEmptyToStringOrNull')]
    public function testNonEmptyToStringOrNull(mixed $value, ?string $expected): void
    {
        self::assertSame($expected, TypeCaster::toNonEmptyStringOrNull($value));
    }

    public static function dataToArray(): array
    {
        return [
            [['hello'], ['hello']],
            ['hello', []],
            [[], []],
            ['', []],
            [null, []],
        ];
    }

    #[DataProvider('dataToArray')]
    public function testToArray(mixed $value, array $expected): void
    {
        self::assertSame($expected, TypeCaster::toArray($value));
    }

    public static function dataToArrayOrNull(): array
    {
        return [
            [['hello'], ['hello']],
            ['hello', null],
            [[], []],
            ['', null],
            [null, null],
            [42, null],
        ];
    }

    #[DataProvider('dataToArrayOrNull')]
    public function testToArrayOrNull(mixed $value, ?array $expected): void
    {
        self::assertSame($expected, TypeCaster::toArrayOrNull($value));
    }
}
