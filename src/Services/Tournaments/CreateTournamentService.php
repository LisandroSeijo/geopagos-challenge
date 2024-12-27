<?php

namespace ATP\Services\Tournaments;

use ATP\DTO\CreateNextPhaseDTO;
use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Payloads\CreateTournamentPayload;
use ATP\Repositories\PlayerRepository;
use ATP\Services\Games\CreateGameService;

class CreateTournamentService {
    protected PersistRepository $persistRepository;

    protected PlayerRepository $playerRepository;

    protected CreateGameService $createGameService;

    protected CreateNextPhaseService $createNextPhaseService;


    private array $players;

    public function __construct(
        PersistRepository $persistRepository, 
        PlayerRepository $playerRepository,
        CreateGameService $createGameService,
        CreateNextPhaseService $createNextPhaseService
    ) {
        $this->persistRepository = $persistRepository;
        $this->playerRepository = $playerRepository;
        $this->createGameService = $createGameService;
        $this->createNextPhaseService = $createNextPhaseService;
    }

    public function excecute(CreateTournamentPayload $createTournamentPayload): Tournament {
        $tournament = null;

        $this->persistRepository->transactional(function() use(&$tournament, $createTournamentPayload) {
            // -1 fast fix
            $actualPhase = $createTournamentPayload->phases() - 1;

            $tournament = new Tournament(
                $createTournamentPayload->name(),
                $createTournamentPayload->gender(),
                $createTournamentPayload->playersCount(),
                $actualPhase,
                1
            );
    
            $this->persistRepository->persist($tournament);
            
            $createNextPhase = new CreateNextPhaseDTO(
                $tournament,
                $createTournamentPayload->players(),
                $actualPhase
            );
            
            $this->createNextPhaseService->excecute($createNextPhase);
        });

        return $tournament;
    }
}
