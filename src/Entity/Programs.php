<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProgramsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProgramsRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'description' => 'partial',
    'duration_weeks' => 'exact'
])]
class Programs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private string $name;

    #[ORM\Column(type: "text")]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private string $description;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\d+$/', message: "Тривалість повинна бути числом у тижнях.")]
    private string $duration_weeks;

    #[ORM\OneToMany(targetEntity: ClientPrograms::class, mappedBy: "program")]
    private Collection $clientPrograms;

    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: "program")]
    private Collection $sessions;

    #[ORM\OneToMany(targetEntity: TrainerPrograms::class, mappedBy: "program")]
    private Collection $trainerPrograms;

    public function __construct()
    {
        $this->clientPrograms = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->trainerPrograms = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }
    public function getDurationWeeks(): string { return $this->duration_weeks; }
    public function setDurationWeeks(string $duration_weeks): static { $this->duration_weeks = $duration_weeks; return $this; }
}