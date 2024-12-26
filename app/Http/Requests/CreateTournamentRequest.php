<?php

namespace App\Http\Requests;

use ATP\Entities\Gender;
use Illuminate\Http\Request;
use ATP\Payloads\CreateTournamentPayload;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateTournamentRequest implements CreateTournamentPayload {
    const NAME = 'name';
    const GENDER = 'gender';
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

    public function gender(): Gender {
        return Gender::from($this->request->input(self::GENDER));
    }
}
