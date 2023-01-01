<?php

namespace Tests\Utils;

use App\Utils\ValidatableEnum;

enum IntBackedTestEnum: int
{
    use ValidatableEnum;

    case A = 1;
    case B = 2;
    case C = 3;
}
