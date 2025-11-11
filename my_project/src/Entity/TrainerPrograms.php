<?php

namespace App\Entity;

use App\Repository\TrainerProgramsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrainerProgramsRepository::class)]
class TrainerPrograms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Trainers::class, inversedBy: "trainerPrograms")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Trainers $trainer = null;

    #[ORM\ManyToOne(targetEntity: Programs::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Programs $program = null;

    public function getId(): ?int { return $this->id; }
    public function getTrainer(): ?Trainers { return $this->trainer; }
    public function setTrainer(?Trainers $trainer): static { $this->trainer = $trainer; return $this; }
    public function getProgram(): ?Programs { return $this->program; }
    public function setProgram(?Programs $program): static { $this->program = $program; return $this; }
}
