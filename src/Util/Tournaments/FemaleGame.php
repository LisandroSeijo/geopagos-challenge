<?php

namespace ATP\Util\Tournament;

use ATP\Entities\Player;

class FemaleGame implements GameStrategy {
    public function play(Player $playerOne, Player $playerTwo): Player {
        return $playerOne;
    }
}
