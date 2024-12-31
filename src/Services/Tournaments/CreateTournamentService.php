<?php

namespace ATP\Services\Tournaments;

use App\Events\TournamentCreatedEvent;
use ATP\DTO\CreatePhaseDTO;
use ATP\Entities\Tournament;
use ATP\Entities\TournamentStatus;
use ATP\Exceptions\InvalidTournamentParticipantsNumber;
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

        if (!$this->isValidPlayersCount($createTournamentPayload->playersCount())) {
            throw new InvalidTournamentParticipantsNumber("Invalid participants");
        }

        $this->persistRepository->transactional(function() use(&$tournament, $createTournamentPayload) {
            $phases = $createTournamentPayload->phases();
            $actualPhase = 1;

            $tournament = new Tournament(
                $createTournamentPayload->name(),
                $createTournamentPayload->gender(),
                TournamentStatus::PENDING,
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
                
            
            return $tournament;
        });

        return $tournament;
    }

    /**
     * We need check $playersCount is power of 2
     * 
     * @param mixed $playersCount
     * @return bool
     */
    private function isValidPlayersCount($playersCount) {
        if ($playersCount < 1) {
            return false;
        }

        return ($playersCount & ($playersCount - 1)) === 0;
    }
}
