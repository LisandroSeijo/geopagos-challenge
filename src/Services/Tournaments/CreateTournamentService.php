<?php

namespace ATP\Services\Tournaments;

use ATP\DTO\CreateGameDTO;
use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Payloads\CreateTournamentPayload;
use ATP\Repositories\PlayerRepository;
use ATP\Exceptions\AssignInvalidGenderException;
use ATP\Services\Games\CreateGameService;

class CreateTournamentService {
    protected PersistRepository $persistRepository;

    protected PlayerRepository $playerRepository;

    protected CreateGameService $createGameService;

    public function __construct(
        PersistRepository $persistRepository, 
        PlayerRepository $playerRepository,
        CreateGameService $createGameService
    ) {
        $this->persistRepository = $persistRepository;
        $this->playerRepository = $playerRepository;
        $this->createGameService = $createGameService;
    }

    public function excecute(CreateTournamentPayload $createTournamentPayload): Tournament {
        $tournament = null;

        $this->persistRepository->transactional(function() use(&$tournament, $createTournamentPayload) {
            $tournament = new Tournament(
                $createTournamentPayload->name(),
                $createTournamentPayload->gender(),
            );
    
            $this->persistRepository->persist($tournament);
            $x = 0;
            $players = $createTournamentPayload->players();

            while ($x < $this->countGames($createTournamentPayload->players())) {
                $playerOne = $this->playerRepository->findById(
                    $this->getPlayerId($players)
                );
                $playerTwo = $this->playerRepository->findById(
                    $this->getPlayerId($players)
                );

                if ($tournament->getGender() !== $playerOne->getGender()) {
                    throw new AssignInvalidGenderException("No se puede agregar un player {$playerOne->getGender()->value} en este torneo");
                }

                if ($tournament->getGender() !== $playerTwo->getGender()) {
                    throw new AssignInvalidGenderException("No se puede agregar uplayern player {$playerOne->getGender()->value} en este torneo");
                }

                $createGameDTO = new CreateGameDTO($tournament, $playerOne, $playerTwo);

                $this->createGameService->excecute($createGameDTO);

                $x++;
            }
        });

        return $tournament;
    }

    private function countGames(array $players): int {
        return count($players) / 2;
    }

    private function getPlayerId(array $players): int {
        // feo...
        $index = rand(0, count($players) -1);
        $id = $players[$index];

        array_splice($players, $index, 1);

        return $id;
    }
}
