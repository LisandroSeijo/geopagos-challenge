<?php

namespace ATP\Services\Tournaments;

use ATP\Payloads\PlayPhasePayload;
use ATP\Repositories\GameRepository;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\TournamentRepository;
use ATP\Util\Tournament\PlayGame;
use ATP\DTO\CreatePhaseDTO;

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

    public function excecute(PlayPhasePayload $playPhasePayload) {
        $winnersIds = [];
        $tournament = $this->tournamentRepository->findById($playPhasePayload->tournamentId());
        $actualPhase = $tournament->getActualPhase();
        
        $games = $this->gameRepository->listByTournamentAndPhase($tournament->getId(), $actualPhase);
        $runGame = new PlayGame($tournament->getGender());
        
        foreach($games as $game) {
            $winner = $runGame->play($game->getPlayerOne(), $game->getPlayerTwo());
            $game->setWinner($winner);
            
            $this->persistRepository->persist($game);
            
            $winnersIds[] = $winner->getId();
        }

        $tournament->setNextPhase();
        $this->persistRepository->persist($tournament);

        $createPhaseDTO = new CreatePhaseDTO(
            $tournament,
            $winnersIds,
            $tournament->getActualPhase()
        );
        
        $this->createPhaseService->excecute($createPhaseDTO);
    }
}
