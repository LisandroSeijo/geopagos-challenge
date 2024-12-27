<?php

namespace ATP\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'tournaments')]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string', enumType: Gender::class)]
    private Gender $gender;

    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: "match", cascade: ["persist", "remove"])]
    private Collection $games;

    public function __construct(string $name, Gender $gender) {
        $this->name = $name;
        $this->gender = $gender;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
            $this->games[] = $game;
            $game->setTournament($this);

        return $this;
    }
}
