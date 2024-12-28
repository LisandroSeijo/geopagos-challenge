<?php

namespace App\Http\Transformers;

use ATP\Entities\Tournament;
use ATP\Entities\Game;

class GameTransformer {
    private PlayerTransformer $playerTransformer;

    public function __construct(PlayerTransformer $playerTransformer) {
        $this->playerTransformer = $playerTransformer;
    }

    public function transform(Game $game): array {
        $winner = $game->getWinner();
        return [
            'id' => $game->getId(),
            'phase' => $game->getPhase(),
            'player_one' => $this->playerTransformer->transform($game->getPlayerOne()),
            'player_two' => $this->playerTransformer->transform($game->getPlayerTwo()),
            'winner' => $winner ? $this->playerTransformer->transform($winner) : null,
        ];
    }

    public function map(array $games): array {
        return array_map(function(Game $game) {
            return $this->transform($game);
        }, $games);
    }
}