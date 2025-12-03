<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\DBAL\Types\Types;
use App\Repository\ClientProgramsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientProgramsRepository::class)]
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
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'client.id' => 'exact',
    'program.id' => 'exact'
])]
#[ApiFilter(DateFilter::class, properties: ['start_date', 'end_date'])]
class ClientPrograms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "clientPrograms")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: Programs::class, inversedBy: "clientPrograms")]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?Programs $program = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeInterface::class)]
    private ?\DateTimeInterface $end_date = null;

    public function getId(): ?int { return $this->id; }
    public function getClient(): ?Client { return $this->client; }
    public function setClient(?Client $client): static { $this->client = $client; return $this; }
    public function getProgram(): ?Programs { return $this->program; }
    public function setProgram(?Programs $program): static { $this->program = $program; return $this; }
    public function getStartDate(): ?\DateTimeInterface { return $this->start_date; }
    public function setStartDate(\DateTimeInterface $start_date): static { $this->start_date = $start_date; return $this; }
    public function getEndDate(): ?\DateTimeInterface { return $this->end_date; }
    public function setEndDate(\DateTimeInterface $end_date): static { $this->end_date = $end_date; return $this; }
}