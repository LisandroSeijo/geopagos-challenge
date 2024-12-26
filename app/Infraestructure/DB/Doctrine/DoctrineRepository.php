<?php

namespace App\Infraestructure\DB\Doctrine;

use ATP\Repositories\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use ATP\Repositories\Pagination\Paginate;

class DoctrineRepository extends EntityRepository implements Repository {
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(static::ENTITY));
    }

    protected function paginate(QueryBuilder $queryBuilder, Paginate $paginate) {
        $queryBuilder->orderBy("t.{$paginate->getSortBy()}", $paginate->getSortOrder())
        ->setFirstResult(($paginate->getPage() - 1) * $paginate->getLimit())
        ->setMaxResults($paginate->getLimit());


        return $queryBuilder->getQuery()->getResult();
    }
}
