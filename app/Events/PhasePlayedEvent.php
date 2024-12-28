<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PhasePlayedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $tournamentId;

    public function __construct($tournamentId)
    {
        $this->tournamentId = $tournamentId;
    }
}
