<?php

namespace Tests\DTO;

use ATP\Entities\Gender;
use ATP\Payloads\CreateTournamentPayload;

class CreateTournamentDTO implements CreateTournamentPayload {
    private string $name;

    private Gender $gender;

    private array $players;

    public function __construct(string $name, Gender $gender, array $players) {
        $this->name = $name;
        $this->gender = $gender;
        $this->players = $players;
    }

    public function name(): string {
        return $this->name;
    }

    public function gender(): Gender {
        return $this->gender;
    }

    /**
     * @return int[]
     */
    public function players(): array {
        return $this->players;
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

        return $phases - 1;
    }
}
