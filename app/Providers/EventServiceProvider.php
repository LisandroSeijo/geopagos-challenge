<?php

namespace App\Providers;

use App\Events\GameCreatedEvent;
use App\Listeners\NotificatePlayerEnrolledGame;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        GameCreatedEvent::class => [
            NotificatePlayerEnrolledGame::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
