<?php

namespace App\Mail;

use ATP\Entities\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlayerEnrolledEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function build()
    {
        return $this
            ->subject('¡Tenés un nuevo partido asignado!')
            ->markdown('emails.player_enrolled')
            ->with([
                'name' => $this->player->getName(),
            ]);
    }
}
