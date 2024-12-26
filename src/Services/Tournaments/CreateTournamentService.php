<?php

namespace ATP\Services\Tournaments;

use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Payloads\CreateTournamentPayload;

class CreateTournamentService {
    protected PersistRepository $persistRepository;

    public function __construct(PersistRepository $persistRepository) {
        $this->persistRepository = $persistRepository;
    }

    public function excecute(CreateTournamentPayload $createTournamentPayload): Tournament {
        $tournament = new Tournament(
            $createTournamentPayload->name(),
            $createTournamentPayload->gender(),
        );

        $this->persistRepository->persist($tournament);

        return $tournament;
    }
}