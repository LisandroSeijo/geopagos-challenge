<?php

namespace ATP\Payloads;

use ATP\Entities\Player;
use ATP\Entities\Tournament;

interface CreateGamePayload {
    public function tournament(): Tournament;

    public function playerOne(): Player;

    public function playerTwo(): Player;

    public function phase(): int;
}