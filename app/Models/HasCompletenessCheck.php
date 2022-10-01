<?php

namespace App\Models;

trait HasCompletenessCheck
{
    abstract function isComplete(): bool;

    protected function isCompleteCheck(array $requiredAttrs): bool
    {
        $complete = true;
        foreach (array_keys($requiredAttrs) as $required) {
            $actualAttr = $this->getAttribute($required);
            if ($actualAttr == null || trim($actualAttr) == '') {
                return false;
            }
        }
        return $complete;
    }
}
