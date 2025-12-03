<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\TrainersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Action\Trainers\CalculateTrainerLoadAction;

#[ORM\Entity(repositoryClass: TrainersRepository::class)]
#[ApiResource(
    security: "is_granted('ROLE_USER')",

    operations: [
        GetCollection::class,
        Get::class,

        new Post(
            security: "is_granted('ROLE_ADMIN')"
        ),

        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),

        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),

        new Get(
            uriTemplate: '/trainers/{id}/load',
            controller: CalculateTrainerLoadAction::class,
            security: "is_granted('ROLE_USER')",
            name: 'calculate_trainer_load',
            read: false,

        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'first_name' => 'partial',
    'last_name' => 'partial',
    'specialty' => 'partial',
    'email' => 'exact'
])]
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
    #[Assert\Regex(pattern: '/^\\+?\\d{10,15}$/', message: "Телефон має бути у форматі +380XXXXXXXXX")]
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

    public function getTrainerPrograms(): Collection
    {
        return $this->trainerPrograms;
    }

    public function getSessions(): Collection
    {
        return $this->sessions;
    }
}