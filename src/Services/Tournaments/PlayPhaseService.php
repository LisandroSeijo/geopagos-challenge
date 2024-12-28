<?php

namespace ATP\Services\Tournaments;

use ATP\Entities\Game;
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
        $tournament = $this->tournamentRepository->findById($playPhasePayload->tournamentId());
        
        if (!$tournament) {
            throw new ResourceNotFoundException('Tournament not found');
        }

        $winnersIds = [];
        
        $games = $this->gameRepository->listByTournamentAndPhase($tournament->getId(), $tournament->getActualPhase());
        $playGame = new PlayGame($tournament->getGender());
        
        foreach($games as $game) {
            $winner = $this->play($playGame, $game);
            
            $winnersIds[] = $winner->getId();
        }

        if ($tournament->inFinalPhase()) {
            $tournament->setWinner($winner);
            $this->persistRepository->persist($tournament);
            
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

    private function play(PlayGame $playGame, Game $game) {
        $winner = $playGame->play($game->getPlayerOne(), $game->getPlayerTwo());
        $game->setWinner($winner);
        
        $this->persistRepository->persist($game);

        return $winner;
    }
}
