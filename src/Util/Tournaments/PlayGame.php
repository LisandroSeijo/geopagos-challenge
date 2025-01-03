<?php

namespace ATP\Util\Tournaments;

use ATP\Entities\Gender;
use ATP\Entities\Player;

class PlayGame {
    private GameStrategy $gameStrategy;

    public function __construct(Gender $gender) {
        $this->gameStrategy = GameStrategyFactory::create($gender);
    }

    public function play(Player $playerOne, Player $playerTwo): Player {
        return $this->gameStrategy->play($playerOne, $playerTwo);
    }
}
