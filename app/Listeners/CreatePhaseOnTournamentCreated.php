<?php

namespace App\Listeners;

use App\Events\TournamentCreatedEvent;
use ATP\Repositories\TournamentRepository;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\DTO\CreatePhaseDTO;


class CreatePhaseOnTournamentCreated
{
    private CreatePhaseService $createPhaseService;

    private TournamentRepository $tournamentRepository;

    public function __construct(CreatePhaseService $createPhaseService, TournamentRepository $tournamentRepository)
    {
        $this->createPhaseService = $createPhaseService;
        $this->tournamentRepository = $tournamentRepository;
    }

    public function handle(TournamentCreatedEvent $event): void
    {
        $tournament = $this->tournamentRepository->findById($event->getTournamentId());

        $createPhaseDTO = new CreatePhaseDTO(
            $tournament,
            $event->getPlayers(),
            $tournament->getActualPhase()
        );
        
        $this->createPhaseService->excecute($createPhaseDTO);
    }
}
