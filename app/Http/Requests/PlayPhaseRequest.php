<?php

namespace App\Http\Requests;

use ATP\Payloads\PlayPhasePayload;
use Illuminate\Http\Request;

class PlayPhaseRequest implements PlayPhasePayload {
    const TOURNAMENT_ID = 'tournamentId';

    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function tournamentId(): int {
        return (int) $this->request->route(self::TOURNAMENT_ID);
    }
}
