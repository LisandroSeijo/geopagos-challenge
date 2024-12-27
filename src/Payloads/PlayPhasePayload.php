<?php

namespace ATP\Payloads;

use ATP\Entities\Tournament;

interface PlayPhasePayload {
    public function tournamentId(): int;
}
