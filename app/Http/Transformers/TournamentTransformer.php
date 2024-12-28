<?php

namespace App\Http\Transformers;

use ATP\Entities\Tournament;

class TournamentTransformer {
    private PlayerTransformer $playerTransformer;

    public function __construct(PlayerTransformer $playerTransformer) {
        $this->playerTransformer = $playerTransformer;
    }

    public function transform(Tournament $tournament): array {
        return [
            'id' => $tournament->getId(),
            'name' => $tournament->getName(),
            'gender' => $tournament->getGender(),
            'count_players' => $tournament->getCountPlayers(),
            'phases' => $tournament->getPhases(),
            'actual_phase' => $tournament->getActualPhase(),
            'status' => $tournament->getStatus(),
            'created_at' => $tournament->getCreatedAt(),
            'winner' => $tournament->getWinner() ? $this->playerTransformer->transform($tournament->getWinner()): null,
        ];
    }

    public function map(array $tournaments): array {
        return array_map(function(Tournament $tournament) {
            return $this->transform($tournament);
        }, $tournaments);
    }
}