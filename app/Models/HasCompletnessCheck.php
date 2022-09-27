<?php

namespace App\Models;

trait HasCompletnessCheck
{
    abstract public function isComplete(): bool;
}
