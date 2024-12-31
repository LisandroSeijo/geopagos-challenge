<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TournamentCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private int $tournamentId;

    private array $players;

    public function __construct(int $tournamentId, array $players) {
        $this->tournamentId = $tournamentId;
        $this->players = $players;
    }

    public function getTournamentId() {
        return $this->tournamentId;
    }

    public function getPlayers(): array {
        return $this->players;
    }
}
