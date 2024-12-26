<?php

namespace App\Infraestructure\DB\Doctrine;

use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\MalePlayer;
use ATP\Repositories\FemalePlayerRepository;

class DoctrineMalePlayerRepository extends DoctrineRepository implements FemalePlayerRepository {
    protected const ENTITY = MalePlayer::class;
}
