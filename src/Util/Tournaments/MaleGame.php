<?php

namespace ATP\Util\Tournament;

use ATP\Entities\MalePlayer;
use ATP\Entities\Player;

class MaleGame implements GameStrategy {
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

    private function hit(MalePlayer $malePlayer): int {
        return $malePlayer->getLucky() + $malePlayer->getAbility() + $malePlayer->getSpeed() + $malePlayer->getPower();
    }
}
