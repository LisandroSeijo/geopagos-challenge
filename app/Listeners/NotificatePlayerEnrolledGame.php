<?php

namespace App\Listeners;

use App\Events\GameCreatedEvent;
use ATP\Repositories\GameRepository;
use Illuminate\Mail\Mailer;
use App\Mail\PlayerEnrolledEmail;

class NotificatePlayerEnrolledGame
{
    private GameRepository $gameRepository;

    private Mailer $mailer;

    public function __construct(GameRepository $gameRepository, Mailer $mailer)
    {
        $this->gameRepository = $gameRepository;
        $this->mailer = $mailer;
    }

    public function handle(GameCreatedEvent $event): void
    {
        $game = $this->gameRepository->findById($event->getGameId());

        $this->mailer->to(
            $game->getPlayerOne()->getEmail()
        )->send(new PlayerEnrolledEmail($game->getPlayerOne()));

        $this->mailer->to(
            $game->getPlayerOne()->getEmail()
        )->send(new PlayerEnrolledEmail($game->getPlayerTwo()));
    }
}
