<?php

namespace Tests\Utils;

use App\Utils\ValidatableEnum;

enum StringBackedTestEnum: string
{
    use ValidatableEnum;

    case A = "A";
    case B = 'B';
    case C = 'C';
}
