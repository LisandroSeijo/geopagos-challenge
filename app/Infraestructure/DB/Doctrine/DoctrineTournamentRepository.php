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
            $queryBulder->andWhere('t.name = :name')
            ->setParameter('name', $filter->get(TournamentFilter::NAME));
        }
        
        return $this->paginate($queryBulder, $paginate);
    }
}
