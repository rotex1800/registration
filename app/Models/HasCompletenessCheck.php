<?php

namespace App\Models;

trait HasCompletenessCheck
{
    abstract public function isComplete(): bool;

    /**
     * @param  array<mixed>  $requiredAttrs
     */
    protected function isCompleteCheck(array $requiredAttrs): bool
    {
        foreach (array_keys($requiredAttrs) as $required) {
            /** @var string $attr */
            $attr = $this->getAttribute($required);
            $actualAttr = strval($attr);
            if ($actualAttr == null || trim($actualAttr) == '') {
                return false;
            }
        }

        return true;
    }
}
