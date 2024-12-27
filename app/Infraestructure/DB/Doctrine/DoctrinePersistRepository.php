<?php

namespace App\Infraestructure\DB\Doctrine;

use Doctrine\ORM\EntityManager;
use ATP\Repositories\PersistRepository;

class DoctrinePersistRepository implements PersistRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function transactional(callable $function): void
    {
        $this->entityManager->getConnection()->transactional($function);
    }
}
