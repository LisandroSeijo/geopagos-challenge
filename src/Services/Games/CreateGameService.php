<?php

namespace ATP\Services\Games;

use ATP\Exceptions\DuplicatePlayerException;
use ATP\Payloads\CreateGamePayload;
use ATP\Repositories\PersistRepository;
use ATP\Entities\Game;

class CreateGameService {
    protected PersistRepository $persistRepository;
    public function __construct(PersistRepository $persistRepository) {
        $this->persistRepository = $persistRepository;
    }

    public function excecute(CreateGamePayload $createGamePayload): Game {
        if ($createGamePayload->playerOne() === $createGamePayload->playerTwo()) {
            throw new DuplicatePlayerException("Duplicate players");
        }

        $game = new Game(
            $createGamePayload->tournament(),
            $createGamePayload->playerOne(),
            $createGamePayload->playerTwo(),
            $createGamePayload->phase()
        );

        $this->persistRepository->persist($game);

        return $game;
    }
}