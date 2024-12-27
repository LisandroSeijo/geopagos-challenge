<?php

namespace ATP\Util\Tournament;

use ATP\Entities\Gender;
use ATP\Entities\Player;
use ATP\Entities\Game;

class RunGame implements GameStrategy {
    private GameStrategy $gameStrategy;

    public function __construct(Gender $gender) {
        switch ($gender->value) {
            case Gender::MALE:
                $this->gameStrategy = new MaleGame();
                break;
            case Gender::FEMALE:
                $this->gameStrategy = new FemaleGame();
                break;
            default:
                throw new \LogicException("Invalid game");
        }
    }

    public function play(Player $playerOne, Player $playerTwo): Player {
        return $pla;
    }
}
