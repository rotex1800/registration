<?php

namespace App\Models;

trait HasCompletenessCheck
{
    abstract public function isComplete(): bool;

    /**
     * @param  array<string>  $requiredAttrs
     * @return bool
     */
    protected function isCompleteCheck(array $requiredAttrs): bool
    {
        foreach (array_keys($requiredAttrs) as $required) {
            $actualAttr = $this->getAttribute($required);
            if ($actualAttr == null || trim($actualAttr) == '') {
                return false;
            }
        }

        return true;
    }
}
