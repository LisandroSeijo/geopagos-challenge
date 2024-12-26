<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\FemalePlayer;
use ATP\Repositories\FemalePlayerRepository;

class DoctrineFemalePlayerRepository extends DoctrineRepository implements FemalePlayerRepository {
    protected const ENTITY = FemalePlayer::class;
}
