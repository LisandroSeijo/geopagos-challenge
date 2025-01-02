<?php

namespace Tests\Feature;

use ATP\Entities\Gender;
use ATP\Entities\Tournament;
use ATP\Entities\TournamentStatus;
use ATP\Exceptions\InvalidTournamentParticipantsNumber;
use ATP\Services\Tournaments\CreateTournamentService;
use ATP\Services\Games\CreateGameService;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\Repositories\PersistRepository;
use Database\Seeders\PlayerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DTO\CreateTournamentDTO;
use Tests\TestCase;
use Mockery;

class CreateTournamentServiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_tournament_service_ok()
    {
        $this->seed(PlayerSeeder::class);

        $persistRepository = app(PersistRepository::class);
        $createGameService = app(CreateGameService::class);
        $createPhaseService = app(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3, 5, 7, 9, 11, 13, 15]
        );

        $tournament = $service->excecute($payload);

        $this->assertInstanceOf(Tournament::class, $tournament);
        $this->assertEquals('Test Tournament', $tournament->getName());
        $this->assertEquals('male', $tournament->getGender()->value);
        $this->assertEquals(TournamentStatus::PENDING, $tournament->getStatus());
        $this->assertEquals(8, $tournament->getCountPlayers());
        $this->assertEquals(3, $tournament->getPhases());
        $this->assertEquals(1, $tournament->getActualPhase());
    }

    public function test_create_tournament_service_invalid_players_count()
    {
        $persistRepository = app(PersistRepository::class);
        $createGameService = app(CreateGameService::class);
        $createPhaseService = app(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $this->expectException(InvalidTournamentParticipantsNumber::class);

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3, 5, 7, 9, 11, 13]
        );

        $service->excecute($payload);
    }

    public function test_create_tournament_service_valid_players_count()
    {
        $persistRepository = app(PersistRepository::class);
        $createGameService = app(CreateGameService::class);
        $createPhaseService = app(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3, 5, 7, 9, 11, 13, 15]
        );

        $tournament = $service->excecute($payload);

        $this->assertInstanceOf(Tournament::class, $tournament);

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3, 5, 7, 9, 11, 13, 15]
        );

        $this->assertInstanceOf(Tournament::class, $tournament);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
