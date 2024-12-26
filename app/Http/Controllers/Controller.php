<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Factory as ValidationFactory;

abstract class Controller
{
    protected ValidationFactory $validator;

    public function __construct(ValidationFactory $validator) {
        $this->validator = $validator;
    }
}
