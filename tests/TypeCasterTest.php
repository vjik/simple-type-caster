<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\SimpleTypeCaster\TypeCaster;

final class TypeCasterTest extends TestCase
{
    public function dataToIntOrNull(): array
    {
        return [
            [42, 42],
            ['42', 42],
            [0, 0],
            ['0', 0],
            ['', null],
            [null, null],
        ];
    }

    /**
     * @dataProvider dataToIntOrNull
     *
     * @param mixed $value
     * @param int|null $expected
     */
    public function testToIntOrNull($value, ?int $expected): void
    {
        $this->assertSame($expected, TypeCaster::toIntOrNull($value));
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
     * @param string|null $expected
     */
    public function testToStringOrNull($value, ?string $expected): void
    {
        $this->assertSame($expected, TypeCaster::toStringOrNull($value));
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
     * @param array $expected
     */
    public function testToArray($value, array $expected): void
    {
        $this->assertSame($expected, TypeCaster::toArray($value));
    }
}

