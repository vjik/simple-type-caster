<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;
use Vjik\SimpleTypeCaster\TypeCaster;

final class TypeCasterTest extends TestCase
{
    public function dataToIntOrNull(): array
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
        ];
    }

    /**
     * @dataProvider dataToIntOrNull
     *
     * @param mixed $value
     */
    public function testToIntOrNull($value, ?int $expected): void
    {
        self::assertSame($expected, TypeCaster::toIntOrNull($value));
    }

    public function dataToFloatOrNull(): array
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
        ];
    }

    /**
     * @dataProvider dataToFloatOrNull
     *
     * @param mixed $value
     */
    public function testToFloatOrNull($value, ?float $expected): void
    {
        self::assertSame($expected, TypeCaster::toFloatOrNull($value));
    }

    public function dataToStringOrNull(): array
    {
        return [
            ['hello', 'hello'],
            ['0', '0'],
            ['', null],
            [null, null],
        ];
    }

    /**
     * @dataProvider dataToStringOrNull
     *
     * @param mixed $value
     */
    public function testToStringOrNull($value, ?string $expected): void
    {
        self::assertSame($expected, TypeCaster::toStringOrNull($value));
    }

    public function dataToArray(): array
    {
        return [
            [['hello'], ['hello']],
            ['hello', []],
            [[], []],
            ['', []],
            [null, []],
        ];
    }

    /**
     * @dataProvider dataToArray
     *
     * @param mixed $value
     */
    public function testToArray($value, array $expected): void
    {
        self::assertSame($expected, TypeCaster::toArray($value));
    }

    public function dataToArrayOrNull(): array
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

    /**
     * @dataProvider dataToArrayOrNull
     *
     * @param mixed $value
     */
    public function testToArrayOrNull($value, ?array $expected): void
    {
        self::assertSame($expected, TypeCaster::toArrayOrNull($value));
    }
}
