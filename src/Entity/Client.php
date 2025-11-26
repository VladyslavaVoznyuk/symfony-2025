<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private string $password;


    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private string $first_name;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private string $last_name;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeInterface $birth_date;

    #[ORM\OneToMany(targetEntity: Payments::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: ClientPrograms::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    private Collection $clientPrograms;

    #[ORM\OneToMany(targetEntity: ClientSession::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    private Collection $clientSessions;

    #[ORM\OneToMany(targetEntity: Attendance::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    private Collection $attendances;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->clientPrograms = new ArrayCollection();
        $this->clientSessions = new ArrayCollection();
        $this->attendances = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }


    public function eraseCredentials(): void
    {

    }


    public function getFirstName(): string {
        return $this->first_name;
    }
    public function setFirstName(string $first_name): static {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLastName(): string {
        return $this->last_name;
    }
    public function setLastName(string $last_name): static {
        $this->last_name = $last_name;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }
    public function setEmail(string $email): static {
        $this->email = $email;
        return $this;
    }

    public function getBirthDate(): \DateTimeInterface {
        return $this->birth_date;
    }
    public function setBirthDate(\DateTimeInterface $birth_date): static {
        $this->birth_date = $birth_date;
        return $this;
    }

    public function getPayments(): Collection {
        return $this->payments;
    }
    public function getClientPrograms(): Collection {
        return $this->clientPrograms;
    }
    public function getClientSessions(): Collection {
        return $this->clientSessions;
    }
    public function getAttendances(): Collection {
        return $this->attendances;
    }
}