<?php

namespace App\Entity;

use App\Repository\TrainingPresenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingPresenceRepository::class)]
class TrainingPresence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_present = null;

    #[ORM\ManyToOne(inversedBy: 'trainingPresences')]
    private ?User $player = null;

    #[ORM\ManyToOne(inversedBy: 'trainingPresences')]
    private ?Training $training = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsPresent(): ?bool
    {
        return $this->is_present;
    }

    public function setIsPresent(?bool $is_present): self
    {
        $this->is_present = $is_present;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }
}
