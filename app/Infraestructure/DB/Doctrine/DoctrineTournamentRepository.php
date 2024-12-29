<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\Tournament;
use ATP\Repositories\TournamentRepository;
use ATP\Repositories\Filters\TournamentFilter;
use ATP\Repositories\Pagination\Paginate;

class DoctrineTournamentRepository extends DoctrineRepository implements TournamentRepository {
    protected const ENTITY = Tournament::class;

    public function filter(TournamentFilter $filter, Paginate $paginate) {
        $queryBulder = $this->createQueryBuilder('t');
        
        if ($filter->has(TournamentFilter::NAME)) {
            $queryBulder->andWhere('LOWER(t.name) LIKE LOWER(:name)')
            ->setParameter('name', "%{$filter->get(TournamentFilter::NAME)}%");
        }

        if ($filter->has(TournamentFilter::GENDER)) {
            $queryBulder->andWhere('t.gender = :gender')
            ->setParameter('gender', $filter->get(TournamentFilter::GENDER));
        }
        
        if ($filter->has(TournamentFilter::STATUS)) {
            $queryBulder->andWhere('t.status = :status')
            ->setParameter('status', $filter->get(TournamentFilter::STATUS));
        }

        if ($filter->has(TournamentFilter::WINNER)) {
            $queryBulder->andWhere('t.winner = :winner')
            ->setParameter('winner', $filter->get(TournamentFilter::WINNER));
        }
        
        return $this->paginate($queryBulder, $paginate);
    }

    public function findById(int $id): ?Tournament {
        return $this->find($id);
    }
}
