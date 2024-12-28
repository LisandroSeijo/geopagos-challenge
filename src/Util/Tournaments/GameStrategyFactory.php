<?php

namespace ATP\Entities\Battle;

use ATP\Entities\Gender;
use ATP\Util\Tournament\GameStrategy;
use ATP\Util\Tournament\MaleGame;
use ATP\Util\Tournament\FemaleGame;

class GameStrategyFactory
{
    public static function create(Gender $gender): GameStrategy
    {
        $gameStrategy = null;

        switch ($gender->value) {
            case Gender::MALE:
                $gameStrategy = new MaleGame();
                break;
            case Gender::FEMALE:
                $gameStrategy = new FemaleGame();
                break;
            default:
                throw new \LogicException("Invalid game");
        }

        return $gameStrategy;
    }
}