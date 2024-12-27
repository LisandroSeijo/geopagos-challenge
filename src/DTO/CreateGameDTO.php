<?php

namespace ATP\DTO;

use ATP\Payloads\CreateGamePayload;
use ATP\Entities\Tournament;
use ATP\Entities\Player;

class CreateGameDTO implements CreateGamePayload {
    private Tournament $tournament;

    private Player $playerOne;

    private Player $playerTwo;

    private int $phase;

    public function __construct(Tournament $tournament, Player $playerOne, Player $playerTwo, int $phase) {
        $this->tournament = $tournament;
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->phase = $phase;
    }

    public function tournament(): Tournament {
        return $this->tournament;
    }

    public function playerOne(): Player {
        return $this->playerOne;
    }

    public function playerTwo(): Player {
        return $this->playerTwo;
    }

    public function phase(): int {
        return $this->phase;
    }
}