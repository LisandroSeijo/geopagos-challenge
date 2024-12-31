<?php

namespace Tests\Feature;

use ATP\Entities\Gender;
use ATP\Exceptions\InvalidTournamentParticipantsNumber;
use Tests\DTO\CreateTournamentDTO;
use Tests\TestCase;
use ATP\Services\Tournaments\CreateTournamentService;
use ATP\Repositories\PersistRepository;
use ATP\Services\Games\CreateGameService;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\Entities\Tournament;
use ATP\Entities\TournamentStatus;
use ATP\DTO\CreatePhaseDTO;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTournamentServiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_tournament_service_ok()
    {
        $persistRepository = app(PersistRepository::class);
        $createGameService = Mockery::mock(CreateGameService::class);
        $createPhaseService = Mockery::mock(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 2, 3, 4, 5, 6, 7, 8]
        );

        $createPhaseService->shouldReceive('excecute')
            ->once()
            ->with(Mockery::type(CreatePhaseDTO::class));

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
        $createGameService = Mockery::mock(CreateGameService::class);
        $createPhaseService = Mockery::mock(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $this->expectException(InvalidTournamentParticipantsNumber::class);

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 2, 3, 4, 5, 6, 7]
        );

        $service->excecute($payload);
    }

    public function test_create_tournament_service_valid_players_count()
    {
        $persistRepository = app(PersistRepository::class);
        $createGameService = Mockery::mock(CreateGameService::class);
        $createPhaseService = Mockery::mock(CreatePhaseService::class);

        $service = new CreateTournamentService(
            $persistRepository,
            $createGameService,
            $createPhaseService
        );

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8]
        );

        $createPhaseService->shouldReceive('excecute')
            ->once()
            ->with(Mockery::type(CreatePhaseDTO::class));

        $tournament = $service->excecute($payload);

        $this->assertInstanceOf(Tournament::class, $tournament);

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8, 
            1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8]
        );

        $this->assertInstanceOf(Tournament::class, $tournament);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
