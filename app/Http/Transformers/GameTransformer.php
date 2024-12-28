<?php

namespace App\Http\Transformers;

use ATP\Entities\Tournament;

class GameTransformer {
    public function __construct() {

    }

    public function transform(Tournament $tournament): array {
        return [
            'id' => $tournament->getId(),
            'name' => $tournament->getName(),
        ];
    }

    public function map(array $tournaments): array {
        return array_map(function(Tournament $tournament) {
            return $this->transform($tournament);
        }, $tournaments);
    }
}