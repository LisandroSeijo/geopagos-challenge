<?php

namespace App\Http\Requests;

use ATP\Payloads\PlayPhasePayload;
use Illuminate\Http\Request;

class PlayPhaseDTO implements PlayPhasePayload {
    private int $tournamentId;

    public function __construct(int $tournamentId) {
        $this->tournamentId = $tournamentId;
    }

    public function tournamentId(): int {
        return $this->tournamentId;
    }
}
