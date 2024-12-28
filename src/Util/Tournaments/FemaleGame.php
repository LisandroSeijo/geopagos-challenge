<?php

namespace ATP\Util\Tournaments;

use ATP\Entities\FemalePlayer;
use ATP\Entities\Player;

class FemaleGame implements GameStrategy {
    public function play(Player $playerOne, Player $playerTwo): Player {
        $tied = false;
        $winner = null;

        do {
            $hitPlayerOne = $this->hit($playerOne);
            $hitPlayerTwo = $this->hit($playerTwo);

            $scorePlayerOne = rand(1, $hitPlayerOne);
            $scorePlayerTwo = rand(1, $hitPlayerTwo);

            if ($scorePlayerOne === $scorePlayerTwo) {
                $tied = true;
            }

            $winner = $scorePlayerOne > $scorePlayerTwo ? $playerOne : $playerTwo;
        } while ($tied);

        return $winner;
    }

    private function hit(FemalePlayer $femalePlayer): int {
        return $femalePlayer->getLucky() + $femalePlayer->getAbility() + $femalePlayer->getReaction();
    }
}
