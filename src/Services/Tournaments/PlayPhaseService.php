<?php

namespace ATP\Services\Tournaments;

use ATP\Entities\Tournament;
use ATP\Exceptions\ResourceNotFoundException;
use ATP\Payloads\PlayPhasePayload;
use ATP\Repositories\GameRepository;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\TournamentRepository;
use ATP\DTO\CreatePhaseDTO;
use ATP\Util\Tournaments\PlayGame;

class PlayPhaseService {
    private TournamentRepository $tournamentRepository;

    private GameRepository $gameRepository;

    private PersistRepository $persistRepository;

    private CreatePhaseService $createPhaseService;

    public function __construct(TournamentRepository $tournamentRepository, GameRepository $gameRepository, PersistRepository $persistRepository, CreatePhaseService $createPhaseService) {
        $this->tournamentRepository = $tournamentRepository;
        $this->gameRepository = $gameRepository;
        $this->persistRepository = $persistRepository;
        $this->createPhaseService = $createPhaseService;
    }

    public function excecute(PlayPhasePayload $playPhasePayload): Tournament {
        $winnersIds = [];
        $tournament = $this->tournamentRepository->findById($playPhasePayload->tournamentId());

        if (!$tournament) {
            throw new ResourceNotFoundException('Tournament not found');
        }

        $actualPhase = $tournament->getActualPhase();
        
        $games = $this->gameRepository->listByTournamentAndPhase($tournament->getId(), $actualPhase);
        $playGame = new PlayGame($tournament->getGender());
        
        foreach($games as $game) {
            $winner = $playGame->play($game->getPlayerOne(), $game->getPlayerTwo());
            $game->setWinner($winner);
            
            $this->persistRepository->persist($game);
            
            $winnersIds[] = $winner->getId();
        }

        if ($tournament->inFinalPhase()) {
            return $tournament;
        }

        $tournament->setNextPhase();
        $this->persistRepository->persist($tournament);

        // Acá se podría disparar un evento PhasePlayed 
        // y un listener que lo escuche y tenga la lógica de chequear si 
        // tiene que crear una siguiente fase o terminó.
        // 
        // Por falta de tiempo lo dejamos acá.
        $createPhaseDTO = new CreatePhaseDTO(
            $tournament,
            $winnersIds,
            $tournament->getActualPhase()
        );
        
        $this->createPhaseService->excecute($createPhaseDTO);

        return $tournament;
    }
}
