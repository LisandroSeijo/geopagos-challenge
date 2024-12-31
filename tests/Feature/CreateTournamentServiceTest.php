<?php

namespace Tests\Feature;

use ATP\Entities\Gender;
use ATP\Exceptions\InvalidTournamentParticipantsNumber;
use Tests\DTO\CreateTournamentDTO;
use Tests\TestCase;
use ATP\Services\Tournaments\CreateTournamentService;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\PlayerRepository;
use ATP\Services\Games\CreateGameService;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\Entities\Tournament;
use ATP\Entities\TournamentStatus;
use ATP\DTO\CreatePhaseDTO;
use Mockery;

class CreateTournamentServiceTest extends TestCase
{
    public function test_create_tournament_service_ok()
    {
        $persistRepository = Mockery::mock(PersistRepository::class);
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

        $persistRepository->shouldReceive('transactional')
            ->once()
            ->with(Mockery::type('callable'))
            ->andReturnUsing(function ($callback) {
                return $callback();
            });

        $persistRepository->shouldReceive('persist')
            ->once()
            ->with(Mockery::type(Tournament::class));

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
        $persistRepository = Mockery::mock(PersistRepository::class);
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
        $persistRepository = Mockery::mock(PersistRepository::class);
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

        $persistRepository->shouldReceive('transactional')
            ->once()
            ->with(Mockery::type('callable'))
            ->andReturnUsing(function ($callback) {
                return $callback();
            });

        $persistRepository->shouldReceive('persist')
            ->once()
            ->with(Mockery::type(Tournament::class));

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
