<?php

declare(strict_types=1);

namespace Vjik\SimpleTypeCaster\Tests\Support;

enum StringEnum: string
{
    case A = 'a';
    case B = 'b';
    case C = 'c';
}
