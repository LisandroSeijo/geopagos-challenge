<?php

namespace ATP\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'male_players')]
class MalePlayer extends Player
{
    #[ORM\Column(type: 'integer')]
    private int $power;

    #[ORM\Column(type: 'integer')]
    private int $speed;

    public function __construct(string $name, $ability, Gender $gender, int $power, int $speed) {
        parent::__construct($name, $ability, $gender);
        $this->power = $power;
        $this->speed = $speed;
    }

    public function getPower(): int
    {
        return $this->power;
    }

    public function setPower(int $power): void
    {
        $this->power = $power;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setMovementSpeed(int $speed): void
    {
        $this->speed = $speed;
    }
}