<?php

namespace ATP\Util\Tournaments;

use ATP\Entities\Gender;

class GameStrategyFactory
{
    public static function create(Gender $gender): GameStrategy
    {
        $gameStrategy = null;

        switch ($gender) {
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