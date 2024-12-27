<?php

namespace ATP\Services\Tournaments;

use ATP\Payloads\PlayPhasePayload;
use ATP\Repositories\GameRepository;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\TournamentRepository;
use ATP\Util\Tournament\RunGame;

class PlayPhaseService {
    private TournamentRepository $tournamentRepository;

    private GameRepository $gameRepository;

    private PersistRepository $persistRepository;

    public function __construct(TournamentRepository $tournamentRepository, GameRepository $gameRepository, PersistRepository $persistRepository) {
        $this->tournamentRepository = $tournamentRepository;
        $this->gameRepository = $gameRepository;
        $this->persistRepository = $persistRepository;
    }

    public function excecute(PlayPhasePayload $playPhasePayload) {
        $winnersIds = [];
        $tournament = $this->tournamentRepository->findById($playPhasePayload->tournamentId());
        $actualPhase = $tournament->getActualPhase();
        
        $games = $this->gameRepository->listByTournamentAndPhase($tournament->getId(), $actualPhase);
        $runGame = new RunGame($tournament->getGender());
        
        foreach($games as $game) {
            $winner = $runGame->play($game->getPlayerOne(), $game->getPlayerTwo());
            $game->setWinner($winner);
            $this->persistRepository->persist($game);
            $winnersIds[] = $winner->getId();
        }

        $tournament->setNextPhase();
        $this->persistRepository->persist($tournament);
    }
}