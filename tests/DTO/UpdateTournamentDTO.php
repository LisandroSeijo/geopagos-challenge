<?php

namespace Tests\DTO;

use ATP\Payloads\UpdateTournamentPayload;

class UpdateTournamentDTO implements UpdateTournamentPayload {
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function name(): string {
        return $this->name;
    }
}
