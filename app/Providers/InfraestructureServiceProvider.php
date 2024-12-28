<?php

namespace App\Providers;

use App\Infraestructure\DB\Doctrine\DoctrineFemalePlayerRepository;
use App\Infraestructure\DB\Doctrine\DoctrineGameRepository;
use App\Infraestructure\DB\Doctrine\DoctrineMalePlayerRepository;
use App\Infraestructure\DB\Doctrine\DoctrinePlayerRepository;
use App\Infraestructure\DB\Doctrine\DoctrineTournamentRepository;
use ATP\Repositories\FemalePlayerRepository;
use ATP\Repositories\GameRepository;
use ATP\Repositories\MalePlayerRepository;
use ATP\Repositories\PersistRepository;
use ATP\Repositories\PlayerRepository;
use Illuminate\Support\ServiceProvider;
use ATP\Repositories\TournamentRepository;
use App\Infraestructure\DB\Doctrine\DoctrinePersistRepository;

class InfraestructureServiceProvider extends ServiceProvider
{
    private $repositories = [
        FemalePlayerRepository::class => DoctrineFemalePlayerRepository::class,
        GameRepository::class => DoctrineGameRepository::class,
        MalePlayerRepository::class => DoctrineMalePlayerRepository::class,
        PlayerRepository::class => DoctrinePlayerRepository::class,
        TournamentRepository::class => DoctrineTournamentRepository::class,
        PersistRepository::class => DoctrinePersistRepository::class,
    ];

    public function register(): void
    {
        foreach($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
