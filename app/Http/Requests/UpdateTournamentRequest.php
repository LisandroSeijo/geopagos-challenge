<?php

namespace App\Http\Requests;

use ATP\Payloads\UpdateTournamentPayload;
use Illuminate\Http\Request;

class UpdateTournamentRequest implements UpdateTournamentPayload {
    const NAME = 'name';

    private Request $request;

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
