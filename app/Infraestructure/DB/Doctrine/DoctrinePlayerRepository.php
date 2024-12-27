<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\Player;
use ATP\Repositories\PlayerRepository;

class DoctrinePlayerRepository extends DoctrineRepository implements PlayerRepository {
    protected const ENTITY = Player::class;

    public function findById(int $id): ?Player {
        return $this->find($id);
    }
}
