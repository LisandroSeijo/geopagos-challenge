<?php

namespace ATP\Util\Tournament;

use ATP\Entities\Player;

interface GameStrategy {
    public function play(Player $playerOne, Player $playerTwo): Player;
}