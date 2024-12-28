<?php

namespace ATP\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use DateTime;

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

    #[ORM\Column(type: 'string', enumType: TournamentStatus::class)]
    private TournamentStatus $status;

    #[ORM\Column(type: 'integer')]
    private int $countPlayers;

    #[ORM\Column(type: 'integer')]
    private int $phases;

    #[ORM\Column(type: 'integer')]
    private int $actualPhase;

    #[ORM\Column(type: "datetime", name: "created_at")]
    private \DateTime $createdAt;


    #[ORM\OneToMany(mappedBy: "tournament", targetEntity: Game::class, cascade: ["persist", "remove"])]
    private Collection $games;

    #[ORM\ManyToOne(targetEntity: Player::class)]
    #[ORM\JoinColumn(name: "winner", referencedColumnName: "id", nullable: true)]
    private ?Player $winner = null;

    public function __construct(string $name, Gender $gender, TournamentStatus $status, int $countPlayers, int $phases, int $actualPhase) {
        $this->name = $name;
        $this->gender = $gender;
        $this->countPlayers = $countPlayers;
        $this->phases = $phases;
        $this->actualPhase = $actualPhase;
        $this->status = $status;
        $this->createdAt = new DateTime("now");
        $this->games = new ArrayCollection();
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

    public function setCountPlayers(int $countPlayers): void {
        $this->countPlayers = $countPlayers;
    }

    public function getCountPlayers(): int {
        return $this->countPlayers;
    }

    public function setPhases(int $phases): void {
        $this->phases = $phases;
    }

    public function getPhases(): int {
        return $this->phases;
    }

    public function setActualPhase(int $actualPhases): void {
        $this->actualPhases = $actualPhases;
    }

    public function getActualPhase(): int {
        return $this->actualPhase;
    }

    public function setNextPhase(): void {
        $this->actualPhase++;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getNextPhase(): int {
        return $this->actualPhase + 1;
    }

    public function setWinner(Player $winner): void
    {
        $this->winner = $winner;
    }

    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    public function getStatus(): TournamentStatus {
        return $this->status;
    }

    public function inFinalPhase(): bool {
        return $this->actualPhase === $this->phases;
    }

    public function isPending(): bool {
        return $this->status === TournamentStatus::PENDING;
    }

    public function isFinished(): bool {
        return $this->status === TournamentStatus::FINISHED;
    }

    public function setInProgress(): void {
        $this->status = TournamentStatus::IN_PROGRESS;
    }

    public function setFinished(): void {
        $this->status = TournamentStatus::FINISHED;
    }
}
