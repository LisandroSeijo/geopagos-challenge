<?php

namespace ATP\Services\Tournaments;

use ATP\Entities\Tournament;
use ATP\Repositories\PersistRepository;
use ATP\Payloads\UpdateTournamentPayload;
use ATP\Repositories\TournamentRepository;
use ATP\Exceptions\ResourceNotFoundException;

class UpdateTournamentService {
    protected PersistRepository $persistRepository;
    protected TournamentRepository $tournamentRepository;

    public function __construct(PersistRepository $persistRepository, TournamentRepository $tournamentRepository) {
        $this->persistRepository = $persistRepository;
        $this->tournamentRepository = $tournamentRepository;
    }

    public function excecute(int $id, UpdateTournamentPayload $updateTournamentPayload): Tournament {
        $tournament = $this->tournamentRepository->findById($id);

        if (!$tournament) {
            throw new ResourceNotFoundException("Tournament {$id} not found");
        }
        
        $tournament->setName($updateTournamentPayload->name());

        $this->persistRepository->persist($tournament);

        return $tournament;
    }
}