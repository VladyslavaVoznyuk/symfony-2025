<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $session_date = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\d+$/', message: "Тривалість у хвилинах повинна бути числом.")]
    private ?string $duration_minutes = null;

    #[ORM\ManyToOne(targetEntity: Programs::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Programs $program = null;

    #[ORM\ManyToOne(targetEntity: Trainers::class, inversedBy: "sessions")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Trainers $trainer = null;

    #[ORM\OneToMany(targetEntity: ClientSession::class, mappedBy: "session", cascade: ['persist', 'remove'])]
    private Collection $clientSessions;

    #[ORM\OneToMany(targetEntity: Attendance::class, mappedBy: "session", cascade: ['persist', 'remove'])]
    private Collection $attendances;

    public function __construct()
    {
        $this->clientSessions = new ArrayCollection();
        $this->attendances = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getSessionDate(): ?\DateTimeInterface { return $this->session_date; }
    public function setSessionDate(\DateTimeInterface $session_date): static { $this->session_date = $session_date; return $this; }
    public function getDurationMinutes(): ?string { return $this->duration_minutes; }
    public function setDurationMinutes(string $duration_minutes): static { $this->duration_minutes = $duration_minutes; return $this; }
    public function getProgram(): ?Programs { return $this->program; }
    public function setProgram(?Programs $program): static { $this->program = $program; return $this; }
    public function getTrainer(): ?Trainers { return $this->trainer; }
    public function setTrainer(?Trainers $trainer): static { $this->trainer = $trainer; return $this; }
}
