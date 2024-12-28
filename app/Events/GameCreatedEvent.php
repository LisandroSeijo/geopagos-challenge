<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $gameId;

    public function __construct(int $gameId) {
        $this->gameId = $gameId;
    }

    public function getGameId() {
        return $this->gameId;
    }
}
