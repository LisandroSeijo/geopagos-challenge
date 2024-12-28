<?php

namespace ATP\DTO;

use ATP\Entities\Tournament;
use ATP\Payloads\CreatePhasePayload;

class CreatePhaseDTO implements CreatePhasePayload {
    private array $players;

    private Tournament $tournament;

    private int $phase;

    public function __construct(Tournament $tournament, array $players, int $phase) {
        $this->tournament = $tournament;
        $this->players = $players;
        $this->phase = $phase;
    }

    public function players(): array {
        return $this->players;
    }

    public function tournament(): Tournament {
        return $this->tournament;
    }

    public function phase(): int {
        return $this->phase;
    }
}