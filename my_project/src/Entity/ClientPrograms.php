<?php

namespace App\Entity;

use App\Repository\ClientProgramsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientProgramsRepository::class)]
class ClientPrograms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "clientPrograms")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Programs::class, inversedBy: "clientPrograms")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Programs $program = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getClient(): ?Client {
        return $this->client;
    }
    public function setClient(?Client $client): static {
        $this->client = $client;
        return $this;
    }

    public function getProgram(): ?Programs {
        return $this->program;
    }
    public function setProgram(?Programs $program): static {
        $this->program = $program;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface {
        return $this->start_date;
    }
    public function setStartDate(\DateTimeInterface $start_date): static {
        $this->start_date = $start_date;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface {
        return $this->end_date;
    }
    public function setEndDate(\DateTimeInterface $end_date): static {
        $this->end_date = $end_date;
        return $this;
    }
}
