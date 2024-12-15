<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests\Support;

use Stringable;

final class StringableObject implements Stringable
{
    public function __construct(
        private readonly string $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
