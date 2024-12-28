<?php

namespace ATP\Services\Tournaments;

use ATP\DTO\CreatePhaseDTO;
use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Payloads\CreateTournamentPayload;
use ATP\Repositories\PlayerRepository;
use ATP\Services\Games\CreateGameService;

class CreateTournamentService {
    protected PersistRepository $persistRepository;

    protected PlayerRepository $playerRepository;

    protected CreateGameService $createGameService;

    protected CreatePhaseService $createPhaseService;


    private array $players;

    public function __construct(
        PersistRepository $persistRepository, 
        PlayerRepository $playerRepository,
        CreateGameService $createGameService,
        CreatePhaseService $createPhaseService
    ) {
        $this->persistRepository = $persistRepository;
        $this->playerRepository = $playerRepository;
        $this->createGameService = $createGameService;
        $this->createPhaseService = $createPhaseService;
    }

    public function excecute(CreateTournamentPayload $createTournamentPayload): Tournament {
        $tournament = null;

        $this->persistRepository->transactional(function() use(&$tournament, $createTournamentPayload) {
            // -1 fast fix
            $phases = $createTournamentPayload->phases() - 1;
            $actualPhase = 1;

            $tournament = new Tournament(
                $createTournamentPayload->name(),
                $createTournamentPayload->gender(),
                $createTournamentPayload->playersCount(),
                $phases,
                $actualPhase
            );
    
            $this->persistRepository->persist($tournament);
            
            $createPhaseDTO = new CreatePhaseDTO(
                $tournament,
                $createTournamentPayload->players(),
                $actualPhase
            );
            
            $this->createPhaseService->excecute($createPhaseDTO);
        });

        return $tournament;
    }
}
