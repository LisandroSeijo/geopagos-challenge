<?php

namespace ATP\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'female_players')]
class FemalePlayer extends Player
{
    #[ORM\Column(type: 'integer')]
    private int $reaction;

    public function __construct(string $name, $ability, Gender $gender, int $reaction) {
        parent::__construct($name, $ability, $gender);
        $this->reaction = $reaction;
    }

    public function getReaction(): int
    {
        return $this->reaction;
    }

    public function setReaction(int $reaction): void
    {
        $this->reaction = $reaction;
    }
}