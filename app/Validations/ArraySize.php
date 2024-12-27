<?php

namespace App\Validations;

use Illuminate\Contracts\Validation\Rule;

class ArraySize implements Rule
{
    private array $allowedSizes;

    public function __construct(array $allowedSizes)
    {
        $this->allowedSizes = $allowedSizes;
    }

    public function passes($attribute, $value): bool
    {
        return in_array(count($value), $this->allowedSizes);
    }

    public function message(): string
    {
        return 'El array debe tener exactamente ' . implode(', ', $this->allowedSizes) . ' elementos.';
    }
}