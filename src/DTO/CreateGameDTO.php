<?php

namespace ATP\DTO;

use ATP\Payloads\CreateGamePayload;
use ATP\Entities\Tournament;
use ATP\Entities\Player;

class CreateGameDTO implements CreateGamePayload {
    private $tournament;

    private $playerOne;

    private $playerTwo;
    public function __construct(Tournament $tournament, Player $playerOne, Player $playerTwo) {
        $this->tournament = $tournament;
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
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
}