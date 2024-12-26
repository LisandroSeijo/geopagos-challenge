<?php

namespace ATP\Repositories\Filters;

use Illuminate\Support\Arr;

abstract class Filter
{
    protected $values = [];

    public function __construct(array $data = [])
    {
        $oClass = new \ReflectionClass(get_called_class());
        $keys = array_values($oClass->getConstants());

        $this->values = Arr::only($data, $keys);
    }

    public function get(string $key, $default = null)
    {
        return Arr::get($this->values, $key, $default);
    }

    public function has(string $key)
    {
        return Arr::has($this->values, $key);
    }
}
