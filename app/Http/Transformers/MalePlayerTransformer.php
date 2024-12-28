<?php

namespace App\Http\Transformers;

use ATP\Entities\MalePlayer;
use ATP\Entities\Tournament;

class MalePlayerTransformer {
    public function __construct() {

    }

    public function transform(MalePlayer $player): array {
        return [
            'id' => $player->getId(),
            'name' => $player->getName(),
            'gender' => $player->getGender(),
        ];
    }

    public function map(array $players): array {
        return array_map(function(MalePlayer $player) {
            return $this->transform($player);
        }, $players);
    }
}