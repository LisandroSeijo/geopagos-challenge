<?php

namespace ATP\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: "games")]
class Game {
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "bigint")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(name: "player_one_id", referencedColumnName: "id", nullable: false)]
    private Player $playerOne;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(name: "player_two_id", referencedColumnName: "id", nullable: false)]
    private Player $playerTwo;

    #[ORM\Column(type: "datetime", name: "created_at")]
    private \DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: "games")]
    #[ORM\JoinColumn(name: "tournament_id", referencedColumnName: "id", nullable: false)]
    private Tournament $tournament;

    #[ORM\Column(type: "integer")]
    private int $phase;

    public function __construct(Tournament $tournament, Player $playerOne, Player $playerTwo, int $phase) {
        $this->tournament = $tournament;
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->phase = $phase;
        $this->createdAt = new DateTime("now");
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerOne(): Player
    {
        return $this->playerOne;
    }

    public function setPlayerOne(Player $playerOne): void
    {
        $this->playerOne = $playerOne;
    }

    public function getPlayerTwo(): Player
    {
        return $this->playerTwo;
    }

    public function setPlayerTwo(Player $playerTwo): void
    {
        $this->playerTwo = $playerTwo;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setTournament(Tournament $tournament): void
    {
        $this->tournament = $tournament;
    }

    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    public function setPhase(int $phase): void
    {
        $this->phase = $phase;
    }

    public function getPhase(): int
    {
        return $this->phase;
    }
}