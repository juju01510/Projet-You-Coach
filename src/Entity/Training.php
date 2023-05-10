<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $info = null;

    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn (onDelete: 'CASCADE')]
    private ?Team $team = null;

    #[ORM\OneToMany(mappedBy: 'training', targetEntity: TrainingPresence::class)]
    private Collection $trainingPresences;

    public function __construct()
    {
        $this->trainingPresences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(?string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection<int, TrainingPresence>
     */
    public function getTrainingPresences(): Collection
    {
        return $this->trainingPresences;
    }

    public function addTrainingPresence(TrainingPresence $trainingPresence): self
    {
        if (!$this->trainingPresences->contains($trainingPresence)) {
            $this->trainingPresences->add($trainingPresence);
            $trainingPresence->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingPresence(TrainingPresence $trainingPresence): self
    {
        if ($this->trainingPresences->removeElement($trainingPresence)) {
            // set the owning side to null (unless already changed)
            if ($trainingPresence->getTraining() === $this) {
                $trainingPresence->setTraining(null);
            }
        }

        return $this;
    }
}
