<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use ATP\Repositories\Pagination\Paginate;

abstract class Controller
{
    protected ValidationFactory $validator;

    public function __construct(ValidationFactory $validator) {
        $this->validator = $validator;
    }

    protected function paginate(Request $request) {
        return new Paginate(
            $request->query(Paginate::PAGE_PARAM, Paginate::DEFAULT_PAGE),
            $request->query(Paginate::LIMIT_PARAM, Paginate::DEFAULT_LIMIT),
            $request->query(Paginate::SORT_BY_PARAM, Paginate::DEFAULT_SORT_BY),
            $request->query(Paginate::SORT_ORDER_PARAM, Paginate::DEFAULT_SORT_ORDER)
        );
    }
}
