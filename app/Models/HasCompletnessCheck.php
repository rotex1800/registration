<?php

namespace App\Models;

trait HasCompletnessCheck
{
    protected $attributes = [];

    public function isComplete(): bool
    {
        $complete = true;
        foreach ($this->attributes as $attribute) {
            if ($attribute == null || trim($attribute) == '') {
                $complete = false;
                break;
            }
        }

        return $complete;
    }
}
