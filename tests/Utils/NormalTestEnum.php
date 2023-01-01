<?php

namespace Tests\Utils;

use App\Utils\ValidatableEnum;

enum NormalTestEnum
{
    use ValidatableEnum;

    case A;
    case B;
    case C;
}
