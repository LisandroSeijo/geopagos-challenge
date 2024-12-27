<?php

namespace App\Validations;

use Illuminate\Contracts\Validation\Rule;

class UniqueIds implements Rule
{
    public function passes($attribute, $value): bool
    {
        return count($value) === count(array_unique($value));
    }

    public function message(): string
    {
        return 'El array de IDs no puede contener valores repetidos.';
    }
}