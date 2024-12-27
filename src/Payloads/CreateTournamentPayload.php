<?php

namespace ATP\Payloads;

use ATP\Entities\Gender;

interface CreateTournamentPayload {
    public function name(): string;

    public function gender(): Gender;

    /**
     * @return int[]
     */
    public function players(): array;
}
