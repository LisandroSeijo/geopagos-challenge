<?php

namespace ATP\Services\Tournaments;

use ATP\DTO\CreateGameDTO;
use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\PlayerRepository;
use ATP\Exceptions\AssignInvalidGenderException;
use ATP\Services\Games\CreateGameService;
use ATP\Payloads\CreateNextPhasePayload;

class CreateNextPhaseService {
    protected PersistRepository $persistRepository;

    protected PlayerRepository $playerRepository;

    protected CreateGameService $createGameService;

    private array $players;

    public function __construct(
        PersistRepository $persistRepository, 
        PlayerRepository $playerRepository,
        CreateGameService $createGameService
    ) {
        $this->persistRepository = $persistRepository;
        $this->playerRepository = $playerRepository;
        $this->createGameService = $createGameService;
    }

    public function excecute(CreateNextPhasePayload $createNextPhasePayload): Tournament {
        $tournament = null;

        $this->persistRepository->transactional(function() use(&$tournament, $createNextPhasePayload) {
            $endGames = $this->countGames($createNextPhasePayload->players());
            $tournament = $createNextPhasePayload->tournament();
            $this->players = $createNextPhasePayload->players();
            $x = 0;

            while ($x < $endGames) {
                $playerOne = $this->playerRepository->findById(
                    $this->getPlayerId()
                );
                $playerTwo = $this->playerRepository->findById(
                    $this->getPlayerId()
                );

                if ($tournament->getGender() !== $playerOne->getGender()) {
                    throw new AssignInvalidGenderException("No se puede agregar un player {$playerOne->getGender()->value} en este torneo");
                }

                if ($tournament->getGender() !== $playerTwo->getGender()) {
                    throw new AssignInvalidGenderException("No se puede agregar uplayern player {$playerOne->getGender()->value} en este torneo");
                }

                $createGameDTO = new CreateGameDTO(
                    $tournament, 
                    $playerOne, 
                    $playerTwo, 
                    $createNextPhasePayload->phase()
                );

                $this->createGameService->excecute($createGameDTO);

                $x++;
            }
        });

        return $tournament;
    }

    private function countGames(array $players): int {
        return floor(count($players) / 2);
    }

    private function getPlayerId(): int {
        // feo pero funciona...
        $index = array_rand($this->players, 1);
        $id = $this->players[$index];

        unset($this->players[$index]);

        return $id;
    }
}
