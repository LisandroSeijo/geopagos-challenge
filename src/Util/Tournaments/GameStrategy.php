<?php

namespace ATP\Util\Tournaments;

use ATP\Entities\Player;

interface GameStrategy {
    public function play(Player $playerOne, Player $playerTwo): Player;
}