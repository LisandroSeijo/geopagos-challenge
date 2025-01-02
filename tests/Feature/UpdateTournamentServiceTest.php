<?php

namespace Tests\Feature;

use ATP\Entities\Gender;
use ATP\Entities\Tournament;
use ATP\Repositories\TournamentRepository;
use ATP\Services\Tournaments\CreateTournamentService;
use ATP\Services\Games\CreateGameService;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\Repositories\PersistRepository;
use Database\Seeders\PlayerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DTO\CreateTournamentDTO;
use Tests\TestCase;
use Mockery;
use ATP\Services\Tournaments\UpdateTournamentService;
use Tests\DTO\UpdateTournamentDTO;
use ATP\Exceptions\ResourceNotFoundException;

class UpdateTournamentServiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_update_tournament_service_ok()
    {
        $this->seed(PlayerSeeder::class);

        $persistRepository = app(PersistRepository::class);
        $createGameService = app(CreateGameService::class);
        $createPhaseService = app(CreatePhaseService::class);
        $updateTournamentService = app(UpdateTournamentService::class);
        $tournamentRepository = app(TournamentRepository::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3]
        );

        $tournament = $service->excecute($payload);

        $this->assertInstanceOf(Tournament::class, $tournament);

        $updateTournamentDTO = new UpdateTournamentDTO('tournamentnameupdated');

        $updateTournamentService->excecute($tournament->getId(), $updateTournamentDTO);

        $updatedTournament = $tournamentRepository->findById($tournament->getId());
    
        $this->assertEquals('tournamentnameupdated', $updatedTournament->getName());
    }

    public function test_update_tournament_service_tournament_not_found_fail()
    {
        $updateTournamentService = app(UpdateTournamentService::class);

        $updateTournamentDTO = new UpdateTournamentDTO('tournamentnameupdated');

        $this->expectException(ResourceNotFoundException::class);
        $updateTournamentService->excecute(123, $updateTournamentDTO);

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
