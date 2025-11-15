<?php

namespace App\Entity;

use App\Repository\TrainersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrainersRepository::class)]
class Trainers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $specialty = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\+?[0-9]{10,15}$/', message: "Телефон має бути у форматі +380XXXXXXXXX")]
    private ?string $phone = null;

    #[ORM\OneToMany(targetEntity: TrainerPrograms::class, mappedBy: "trainer", cascade: ['persist', 'remove'])]
    private Collection $trainerPrograms;

    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: "trainer", cascade: ['persist', 'remove'])]
    private Collection $sessions;

    public function __construct()
    {
        $this->trainerPrograms = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getFirstName(): ?string { return $this->first_name; }
    public function setFirstName(string $first_name): static { $this->first_name = $first_name; return $this; }
    public function getLastName(): ?string { return $this->last_name; }
    public function setLastName(string $last_name): static { $this->last_name = $last_name; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function getSpecialty(): ?string { return $this->specialty; }
    public function setSpecialty(string $specialty): static { $this->specialty = $specialty; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): static { $this->phone = $phone; return $this; }
}
