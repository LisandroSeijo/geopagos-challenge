<?php

namespace App\Http\Transformers;

use ATP\Entities\Player;

class PlayerTransformer {
    public function __construct() {

    }

    public function transform(Player $player): array {
        return [
            'id' => $player->getId(),
            'name' => $player->getName(),
            'gender' => $player->getGender(),
        ];
    }

    public function map(array $players): array {
        return array_map(function(Player $player) {
            return $this->transform($player);
        }, $players);
    }
}