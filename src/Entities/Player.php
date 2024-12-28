<?php

namespace ATP\Entities;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: 'players')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'player' => Player::class,
    'male_player' => MalePlayer::class,
    'female_player' => FemalePlayer::class,
])]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'smallint')]
    private int $ability;

    #[ORM\Column(type: 'string', enumType: Gender::class)]
    private Gender $gender;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'datetime', name: 'created_at')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime', name: 'updated_at')]
    private DateTime $updatedAt;

    public function __construct(string $name, $ability, Gender $gender, string $email)
    {
        $this->name = $name;
        $this->ability = $ability;
        $this->gender = $gender;
        $this->email = $email;
        $this->createdAt = new DateTime("now");
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

    public function getAbility(): int
    {
        return $this->ability;
    }

    public function setAbility(int $ability): void
    {
        $this->ability = $ability;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function getLucky(): int {
        return rand(1, 10);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
