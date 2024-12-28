<?php

namespace App\Http\Requests;

use ATP\Entities\Gender;
use Illuminate\Http\Request;
use ATP\Payloads\CreateTournamentPayload;

class CreateTournamentRequest implements CreateTournamentPayload {
    const NAME = 'name';
    const GENDER = 'gender';
    const PLAYERS = 'players';
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function request() {
        return $this->request;
    }

    public function name(): string {
        return $this->request->input(self::NAME);
    }

    public function gender(): Gender {
        return Gender::from($this->request->input(self::GENDER));
    }
    /**
     * 
     * @return int[]
     */
    public function players(): array {
        return $this->request->input(self::PLAYERS); 
    }

    public function playersCount(): int {
        return count($this->players());
    }

    public function phases(): int {
        $phases = 0;
        $count = $this->playersCount();

        while ($count > 0) {
            $count = floor($count / 2);
            $phases++;
        }

        return $phases;
    }
}
