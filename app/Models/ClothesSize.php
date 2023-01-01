<?php

namespace App\Models;

use App\Utils\ValidatableEnum;

enum ClothesSize: string
{
    use ValidatableEnum;

    case NA = 'NA';
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';
    case XXXL = 'XXXL';

    public function displayName(): string
    {
        if ($this == ClothesSize::NA) {
            return '--';
        }
        return $this->value;
    }
}
