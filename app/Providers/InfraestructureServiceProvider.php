<?php

namespace App\Providers;

use App\Infraestructure\DB\Doctrine\DoctrineTournamentRepository;
use ATP\Repositories\PersistRepository;
use Illuminate\Support\ServiceProvider;
use ATP\Repositories\TournamentRepository;
use App\Infraestructure\DB\Doctrine\DoctrinePersistRepository;

class InfraestructureServiceProvider extends ServiceProvider
{
    private $repositories = [
        TournamentRepository::class => DoctrineTournamentRepository::class,
        PersistRepository::class => DoctrinePersistRepository::class,
    ];

    public function register(): void
    {
        foreach($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    public function boot(): void
    {
        //
    }
}
