<?php

namespace ATP\Repositories;

use ATP\Entities\Tournament;
use ATP\Repositories\Filters\TournamentFilter;
use ATP\Repositories\Pagination\Paginate;

interface TournamentRepository extends Repository {
   public function filter(TournamentFilter $filter, Paginate $paginate);

   public function findById(int $id): ?Tournament;
}
