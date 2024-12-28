<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\Game;
use ATP\Repositories\GameRepository;

class DoctrineGameRepository extends DoctrineRepository implements GameRepository {
    protected const ENTITY = Game::class;

    public function listByTournamentAndPhase(int $tournamentId, int $phase): array {
        $queryBuilder = $this->createQueryBuilder("g");

        $queryBuilder->where('g.tournament = :tounamentId')
        ->setParameter('tounamentId', $tournamentId);

        $queryBuilder->andWhere('g.phase = :phase')
        ->setParameter('phase', $phase);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findById(int $id): ?Game {
        return $this->find($id);
    }
}
