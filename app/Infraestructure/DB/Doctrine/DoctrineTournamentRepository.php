<?php

namespace App\Infraestructure\DB\Doctrine;

use ATP\Repositories\TournamentRepository;
use App\Infraestructure\DB\Doctrine\DoctrineRepository;
use ATP\Entities\Tournament;

class DoctrineTournamentRepository extends DoctrineRepository implements TournamentRepository {
    protected const ENTITY = Tournament::class;
}
