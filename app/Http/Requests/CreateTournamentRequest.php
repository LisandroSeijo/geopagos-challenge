<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use ATP\Payloads\CreateTournamentPayload;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateTournamentRequest implements CreateTournamentPayload {
    const NAME = 'name';
    private Request $request;
    private ValidationFactory $validation;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function request() {
        return $this->request;
    }

    public function name(): string {
        return $this->request->input(self::NAME);
    }
}
