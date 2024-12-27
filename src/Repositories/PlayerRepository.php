<?php

namespace ATP\Repositories;

use ATP\Entities\Player;

interface PlayerRepository extends Repository {
    public function findById(int $id): ?Player;
}
