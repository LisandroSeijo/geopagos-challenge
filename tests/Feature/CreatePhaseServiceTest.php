<?php

namespace Tests\Unit\Services\Tournaments;

use ATP\DTO\CreatePhaseDTO;
use ATP\Entities\Tournament;
use ATP\Entities\Gender;
use ATP\Repositories\GameRepository;
use ATP\Services\Tournaments\CreatePhaseService;
use ATP\Services\Tournaments\CreateTournamentService;
use Tests\TestCase;
use Database\Seeders\PlayerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DTO\CreateTournamentDTO;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\PlayerRepository;
use ATP\Services\Games\CreateGameService;

class CreatePhaseServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testExecuteCreatesGamesSuccessfully()
    {
        $this->seed(PlayerSeeder::class);

        $persistRepository = app(PersistRepository::class);
        $playerRepository = app(PlayerRepository::class);
        $gameRepository = app(GameRepository::class);
        $createGameService = app(CreateGameService::class);

        $createPhaseService = new CreatePhaseService(
            $persistRepository,
            $playerRepository,
            $createGameService
        );

        $tournament = $this->createTurnament();
        $phase = $tournament->getNextPhase();

        $createPhaseDTO = new CreatePhaseDTO(
            $tournament,
            [1, 3],
            $phase
        );

        $games = $gameRepository->listByTournamentAndPhase($tournament->getId(), $phase);

        $this->assertCount(0, $games);

        $tournament = $createPhaseService->excecute($createPhaseDTO);

        $games = $gameRepository->listByTournamentAndPhase($tournament->getId(), $phase);

        $this->assertCount(1, $games);
    }

    private function createTurnament(): Tournament {
        $this->seed(PlayerSeeder::class);

        $createTournamentService = app(CreateTournamentService::class);

        $payload = new CreateTournamentDTO(
            'Test Tournament',
            Gender::MALE,
            [1, 3, 5, 7],
        );

        return $createTournamentService->excecute($payload);
    }
}