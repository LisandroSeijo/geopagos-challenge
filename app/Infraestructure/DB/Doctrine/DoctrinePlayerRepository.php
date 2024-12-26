<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\Player;
use ATP\Repositories\FemalePlayerRepository;

class DoctrinePlayerRepository extends DoctrineRepository implements FemalePlayerRepository {
    protected const ENTITY = Player::class;
}
