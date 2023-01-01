<?php

namespace App\Utils;

use BackedEnum;
use Exception;

trait ValidatableEnum
{
    /**
     * @throws Exception
     */
    public static function inEnumCasesValidationString(): string
    {
        if (! enum_exists(self::class)) {
            throw new Exception('The ValidatableEnum trait can only be applied to enums');
        }
        $validationString = 'in:';
        for ($i = 0; $i < count(self::cases()); $i++) {
            $validationString .= self::getValue($i);
            if ($i < count(self::cases()) - 1) {
                $validationString .= ',';
            }
        }

        return $validationString;
    }

    /**
     * @param  int  $index
     * @return string
     */
    private static function getValue(int $index): string
    {
        if (is_a(self::class, BackedEnum::class, true)) {
            return self::cases()[$index]->value;
        } else {
            return self::cases()[$index]->name;
        }
    }
}
