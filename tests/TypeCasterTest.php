<?php

declare(strict_types=1);

use Vjik\SimpleTypeCaster\Tests\Support\IntEnum;
use Vjik\SimpleTypeCaster\Tests\Support\StringEnum;
use Vjik\SimpleTypeCaster\Tests\Support\StringableObject;
use Vjik\SimpleTypeCaster\TypeCaster;

test(
    'toInt()',
    function (int $expected, mixed $value): void {
        expect(TypeCaster::toInt($value))->toBe($expected);
    }
)->with([
    [12000, '12 000'],
    [12000, ' 12 000 '],
    [42, 42],
    [42, '42'],
    [0, 0],
    [0, '0'],
    [0, ''],
    [0, null],
    [0, new stdClass()],
    [-1, -1],
    [-1, '-1'],
]);

test(
    'toInt() with params',
    function (int $expected, mixed $value, ?int $min, ?int $max, int $default): void {
        expect(TypeCaster::toInt($value, $min, $max, $default))->toBe($expected);
    }
)->with([
    [0, 0, null, null, 7],
    [0, '0', null, null, 7],
    [7, '', null, null, 7],
    [7, null, null, null, 7],
    [7, new stdClass(), null, null, 7],
    [0, 7, 8, null, 0],
    [7, 7, 6, null, 0],
    [7, 7, 7, null, 0],
    [0, 7, null, 6, 0],
    [7, 7, null, 7, 0],
    [7, 7, null, 8, 0],
    [7, 7, 6, 8, 0],
]);

test(
    'toIntOrNull()',
    function (mixed $value, ?int $expected): void {
        expect(TypeCaster::toIntOrNull($value))->toBe($expected);
    }
)->with([
    ['12 000', 12000],
    [' 12 000 ', 12000],
    [42, 42],
    ['42', 42],
    [0, 0],
    ['0', 0],
    ['', null],
    [null, null],
    [new stdClass(), null],
    [-1, -1],
    ['-1', -1],
]);

test(
    'toIntOrNull() with params',
    function (?int $expected, mixed $value, ?int $min, ?int $max): void {
        expect(TypeCaster::toIntOrNull($value, $min, $max))->toBe($expected);
    }
)->with([
    [null, 7, 8, null],
    [7, 7, 6, null],
    [7, 7, 7, null],
    [null, 7, null, 6],
    [7, 7, null, 7],
    [7, 7, null, 8],
    [7, 7, 6, 8],
]);

test(
    'toNonNegativeIntOrNull()',
    function (mixed $value, ?int $expected): void {
        expect(TypeCaster::toNonNegativeIntOrNull($value))->toBe($expected);
    }
)->with([
    ['12 000', 12000],
    [' 12 000 ', 12000],
    [42, 42],
    ['42', 42],
    [0, 0],
    ['0', 0],
    ['', null],
    [null, null],
    [new stdClass(), null],
    [-1, null],
    ['-1', null],
]);

test(
    'toPositiveIntOrNull()',
    function (mixed $value, ?int $expected): void {
        expect(TypeCaster::toPositiveIntOrNull($value))->toBe($expected);
    }
)->with([
    ['12 000', 12000],
    [' 12 000 ', 12000],
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
]);

test(
    'toFloatOrNull()',
    function (mixed $value, ?float $expected): void {
        expect(TypeCaster::toFloatOrNull($value))->toBe($expected);
    }
)->with([
    ['12 500,90', 12500.9],
    ['13.56', 13.56],
    ['-13.56', -13.56],
    [' 13.56 ', 13.56],
    [13.56, 13.56],
    [1, 1.0],
    [0, 0.0],
    ['0', 0.0],
    ['', null],
    [null, null],
    [new stdClass(), null],
    [[], null],
    [['a'], null],
]);

test(
    'toPositiveFloatOrNull()',
    function (mixed $value, ?float $expected): void {
        expect(TypeCaster::toPositiveFloatOrNull($value))->toBe($expected);
    }
)->with([
    ['12 500,90', 12500.9],
    ['13.56', 13.56],
    ['-13.56', null],
    ['-0.000001', null],
    ['0.000001', 0.000001],
    [' 13.56 ', 13.56],
    [13.56, 13.56],
    [1, 1.0],
    [0, null],
    ['0', null],
    ['', null],
    [null, null],
    [new stdClass(), null],
    [[], null],
    [['a'], null],
]);

test(
    'toString()',
    function (string $expected, mixed $value): void {
        expect(TypeCaster::toString($value))->toBe($expected);
    }
)->with([
    ['hello', 'hello'],
    ['0', '0'],
    ['12', 12],
    ['4.5', 4.5],
    ['1', true],
    ['', false],
    ['', ''],
    ['', null],
    ['', []],
    ['', ['a']],
    ['  hello  ', '  hello  '],
    'stringable-object' => ['hello', new StringableObject('hello')],
    'non-stringable-object' => ['', new stdClass()],
]);

test(
    'toString() with trim',
    function (string $expected, mixed $value, bool $trim): void {
        expect(TypeCaster::toString($value, trim: $trim))->toBe($expected);
    }
)->with([
    ['', ' ', true],
    ['hello', '  hello  ', true],
    [' ', ' ', false],
    ['  hello  ', '  hello  ', false],
]);

test(
    'toStringOrNull()',
    function (?string $expected, mixed $value): void {
        expect(TypeCaster::toStringOrNull($value))->toBe($expected);
    }
)->with([
    ['hello', 'hello'],
    ['0', '0'],
    [null, ''],
    [null, null],
    ['25', 25],
    [null, []],
    [null, ['a']],
    [' test ', ' test '],
    ['  ', '  '],
    'stringable-object' => ['hello', new StringableObject('hello')],
    'non-stringable-object' => [null, new stdClass()],
]);

test(
    'toStringOrNull() with trim',
    function (?string $expected, mixed $value, bool $trim): void {
        expect(TypeCaster::toStringOrNull($value, trim: $trim))->toBe($expected);
    }
)->with([
    ['test', ' test ', true],
    [null, '  ', true],
    [' test ', ' test ', false],
    ['  ', '  ', false],
]);

test(
    'toArray()',
    function (mixed $value, array $expected): void {
        expect(TypeCaster::toArray($value))->toBe($expected);
    }
)->with([
    [['hello'], ['hello']],
    ['hello', []],
    [[], []],
    ['', []],
    [null, []],
]);

test(
    'toArrayOrNull()',
    function (mixed $value, ?array $expected): void {
        expect(TypeCaster::toArrayOrNull($value))->toBe($expected);
    }
)->with([
    [['hello'], ['hello']],
    ['hello', null],
    [[], []],
    ['', null],
    [null, null],
    [42, null],
]);

test(
    'toArrayOfBackedEnums()',
    function (array $expected, string $class, mixed $value): void {
        expect(TypeCaster::toArrayOfBackedEnums($class, $value))->toBe($expected);
    }
)->with([
    [[], IntEnum::class, null],
    [[], IntEnum::class, 1],
    [[], IntEnum::class, 'a'],
    [[], IntEnum::class, [99]],
    [[], IntEnum::class, ['a']],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [IntEnum::A, IntEnum::C]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, 3]],
    [[IntEnum::A, 2 => IntEnum::C], IntEnum::class, [1, 4, 3]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, IntEnum::C]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, IntEnum::C, 2.2]],
    [[], StringEnum::class, null],
    [[], StringEnum::class, 1],
    [[], StringEnum::class, 'a'],
    [[], StringEnum::class, [1]],
    [[], StringEnum::class, ['x']],
    [[StringEnum::A, StringEnum::C], StringEnum::class, [StringEnum::A, StringEnum::C]],
    [[StringEnum::A, StringEnum::C], StringEnum::class, ['a', 'c']],
    [[StringEnum::A, 2 => StringEnum::C], StringEnum::class, ['a', 'd', 'c']],
    [[StringEnum::A, StringEnum::C], StringEnum::class, ['a', StringEnum::C]],
]);

test(
    'toListOfBackedEnums()',
    function (array $expected, string $class, mixed $value): void {
        expect(TypeCaster::toListOfBackedEnums($class, $value))->toBe($expected);
    }
)->with([
    [[], IntEnum::class, null],
    [[], IntEnum::class, 1],
    [[], IntEnum::class, 'a'],
    [[], IntEnum::class, [99]],
    [[], IntEnum::class, ['a']],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [IntEnum::A, IntEnum::C]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, 3]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, 4, 3]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, IntEnum::C]],
    [[IntEnum::A, IntEnum::C], IntEnum::class, [1, IntEnum::C, 2.2]],
    [[], StringEnum::class, null],
    [[], StringEnum::class, 1],
    [[], StringEnum::class, 'a'],
    [[], StringEnum::class, [1]],
    [[], StringEnum::class, ['x']],
    [[StringEnum::A, StringEnum::C], StringEnum::class, [StringEnum::A, StringEnum::C]],
    [[StringEnum::A, StringEnum::C], StringEnum::class, ['a', 'c']],
    [[StringEnum::A, StringEnum::C], StringEnum::class, ['a', 'd', 'c']],
    [[StringEnum::A, StringEnum::C], StringEnum::class, ['a', StringEnum::C]],
]);

test(
    'toBackedEnumOrNull()',
    function (?BackedEnum $expected, string $class, mixed $value): void {
        expect(TypeCaster::toBackedEnumOrNull($class, $value))->toBe($expected);
    }
)->with([
    [null, StringEnum::class, null],
    [null, StringEnum::class, 1],
    [null, StringEnum::class, 'x'],
    [null, StringEnum::class, ['a']],
    [StringEnum::A, StringEnum::class, 'a'],
    [StringEnum::A, StringEnum::class, StringEnum::A],
    [null, IntEnum::class, null],
    [null, IntEnum::class, 99],
    [null, IntEnum::class, 'x'],
    [null, IntEnum::class, '1'],
    [null, IntEnum::class, [1]],
    [IntEnum::A, IntEnum::class, 1],
    [IntEnum::A, IntEnum::class, IntEnum::A],
]);

test(
    'toListOfNonEmptyStrings()',
    function (array $expected, mixed $value, ?bool $trim = null): void {
        $result = $trim === null
            ? TypeCaster::toListOfNonEmptyStrings($value)
            : TypeCaster::toListOfNonEmptyStrings($value, $trim);
        expect($result)->toBe($expected);
    }
)->with([
    [[], []],
    [[], 12],
    [['12'], [12]],
    [['hello ', 'world'], ['hello ', 'world']],
    [['hello', 'world'], ['hello ', 'world'], true],
    [['hello', 'world'], ['hello', [], 'world']],
]);

test(
    'toDateTimeOrNullByTimestamp()',
    function (int|null $expected, mixed $value): void {
        $result = TypeCaster::toDateTimeOrNullByTimestamp($value);
        expect($result?->getTimestamp())->toBe($expected);
    }
)->with([
    [1734272324, 1734272324],
    [1734272324, 1734272324.99],
    [1734272324, '1734272324'],
    [1734272324, new StringableObject('1734272324')],
    [null, new stdClass()],
    [0, 'hello'],
    [null, null],
    [null, ''],
]);

test(
    'toDateTimeOrNullByFormat()',
    function (?DateTimeImmutable $expected, mixed $value, string $format, ?DateTimeZone $timeZone = null): void {
        $result = TypeCaster::toDateTimeOrNullByFormat($value, $format, $timeZone);
        expect($result?->format('d.m.Y'))->toBe($expected?->format('d.m.Y'));
    }
)->with([
    'valid Y-m-d format' => [
        new DateTimeImmutable('2023-12-31', new DateTimeZone('UTC')),
        '2023-12-31',
        'Y-m-d',
        new DateTimeZone('UTC'),
    ],
    'valid d/m/Y format' => [
        new DateTimeImmutable('2023-01-15', new DateTimeZone('Europe/Moscow')),
        '15/01/2023',
        'd/m/Y',
        new DateTimeZone('Europe/Moscow'),
    ],
    'null input' => [null, null, 'Y-m-d', new DateTimeZone('UTC')],
    'empty string' => [null, '', 'Y-m-d', new DateTimeZone('UTC')],
    'invalid format' => [null, '2023-12-31', 'd.m.Y', new DateTimeZone('UTC')],
    'non-string castable input' => [
        new DateTimeImmutable('2024-04-08', new DateTimeZone('UTC')),
        20240408,
        'Ymd',
        new DateTimeZone('UTC'),
    ],
    'non-string non-castable input' => [null, new stdClass(), 'Y-m-d', new DateTimeZone('UTC')],
]);
