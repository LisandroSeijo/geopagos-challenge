<?php

namespace App\Http\Transformers;

use ATP\Entities\Tournament;
use ATP\Entities\Game;

class TournamentTransformer {
    private PlayerTransformer $playerTransformer;

    private GameTransformer $gameTransformer;

    public function __construct(PlayerTransformer $playerTransformer, GameTransformer $gameTransformer) {
        $this->playerTransformer = $playerTransformer;
        $this->gameTransformer = $gameTransformer;
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
            'phases_desctiption' => $this->phases($tournament)
        ];
    }

    public function map(array $tournaments): array {
        return array_map(function(Tournament $tournament) {
            return $this->transform($tournament);
        }, $tournaments);
    }

    private function phases(Tournament $tournament): array {
        $phasesDescription = [];
        $phases = $tournament->getPhases();
        $actualPhase = 1;

        while ($actualPhase < $phases) {
            $games = $tournament->getGames()->filter(function(Game $game) use($actualPhase) {
                return $game->getPhase() === $actualPhase;
            })->toArray();

            $phasesDescription[] = [
                'phase' => $actualPhase,
                'games' => $this->gameTransformer->map($games)
            ];
            $actualPhase++;
        }

        return $phasesDescription;
    }
}