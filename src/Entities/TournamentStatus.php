<?php

namespace ATP\Entities;

enum TournamentStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';

    case FINISHED = 'finished';
}