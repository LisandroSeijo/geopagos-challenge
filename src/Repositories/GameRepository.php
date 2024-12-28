<?php

namespace ATP\Repositories;

use ATP\Entities\Game;

interface GameRepository extends Repository {
    /**
     * @return Game[]
     */
    public function listByTournamentAndPhase(int $tournamentId, int $phase): array;

    public function findById(int $id): ?Game;
}