<?php

namespace ATP\Repositories;

interface PersistRepository {
    public function persist($entity);

    public function transactional(callable $function): void;
}
