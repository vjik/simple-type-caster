<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests;

use BackedEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\SimpleTypeCaster\Tests\Support\IntEnum;
use Vjik\SimpleTypeCaster\Tests\Support\StringEnum;
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

    public static function dataToIntOrNullWithParams(): array
    {
        return [
            [null, 7, 8, null],
            [7, 7, 6, null],
            [7, 7, 7, null],
            [null, 7, null, 6],
            [7, 7, null, 7],
            [7, 7, null, 8],
            [7, 7, 6, 8],
        ];
    }

    #[DataProvider('dataToIntOrNullWithParams')]
    public function testToIntOrNullWithParams(?int $expected, mixed $value, ?int $min, ?int $max): void
    {
        self::assertSame($expected, TypeCaster::toIntOrNull($value, $min, $max));
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

    public static function dataToPositiveIntOrNull(): array
    {
        return [
            ['12 000', 12000],
            [42, 42],
            ['42', 42],
            [0, null],
            ['0', null],
            [1, 1],
            ['1', 1],
            ['', null],
            [null, null],
            [new stdClass(), null],
            [-1, null],
            ['-1', null],
        ];
    }

    #[DataProvider('dataToPositiveIntOrNull')]
    public function testToPositiveIntOrNull(mixed $value, ?int $expected): void
    {
        self::assertSame($expected, TypeCaster::toPositiveIntOrNull($value));
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
            ['', null],
            [' test ', 'test'],
            ['  ', null],
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

    public static function dataToArrayOfBackedEnums(): iterable
    {
        yield [[], IntEnum::class, null];
        yield [[], IntEnum::class, 1];
        yield [[], IntEnum::class, 'a'];
        yield [[], IntEnum::class, [99]];
        yield [[], IntEnum::class, ['a']];
        yield [
            [IntEnum::A, IntEnum::C],
            IntEnum::class,
            [IntEnum::A, IntEnum::C],
        ];
        yield [
            [IntEnum::A, IntEnum::C],
            IntEnum::class,
            [1, 3],
        ];
        yield [
            [IntEnum::A, 2 => IntEnum::C],
            IntEnum::class,
            [1, 4, 3],
        ];
        yield [
            [IntEnum::A, IntEnum::C],
            IntEnum::class,
            [1, IntEnum::C],
        ];
        yield [
            [IntEnum::A, IntEnum::C],
            IntEnum::class,
            [1, IntEnum::C, 2.2],
        ];
        yield [[], StringEnum::class, null];
        yield [[], StringEnum::class, 1];
        yield [[], StringEnum::class, 'a'];
        yield [[], StringEnum::class, [1]];
        yield [[], StringEnum::class, ['x']];
        yield [
            [StringEnum::A, StringEnum::C],
            StringEnum::class,
            [StringEnum::A, StringEnum::C],
        ];
        yield [
            [StringEnum::A, StringEnum::C],
            StringEnum::class,
            ['a', 'c'],
        ];
        yield [
            [StringEnum::A, 2 => StringEnum::C],
            StringEnum::class,
            ['a', 'd', 'c'],
        ];
        yield [
            [StringEnum::A, StringEnum::C],
            StringEnum::class,
            ['a', StringEnum::C],
        ];
    }

    #[DataProvider('dataToArrayOfBackedEnums')]
    public function testToArrayOfBackedEnums(array $expected, string $class, mixed $value): void
    {
        self::assertSame($expected, TypeCaster::toArrayOfBackedEnums($class, $value));
    }

    public static function dataToBackedEnumOrNull(): iterable
    {
        yield [null, StringEnum::class, null];
        yield [null, StringEnum::class, 1];
        yield [null, StringEnum::class, 'x'];
        yield [null, StringEnum::class, ['a']];
        yield [StringEnum::A, StringEnum::class, 'a'];
        yield [null, IntEnum::class, null];
        yield [null, IntEnum::class, 99];
        yield [null, IntEnum::class, 'x'];
        yield [null, IntEnum::class, '1'];
        yield [null, IntEnum::class, [1]];
        yield [IntEnum::A, IntEnum::class, 1];
    }

    #[DataProvider('dataToBackedEnumOrNull')]
    public function testToBackedEnumOrNull(?BackedEnum $expected, string $class, mixed $value): void
    {
        self::assertSame($expected, TypeCaster::toBackedEnumOrNull($class, $value));
    }
}
