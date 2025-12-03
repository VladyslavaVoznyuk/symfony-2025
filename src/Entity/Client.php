<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    routePrefix: '/clients',
    paginationItemsPerPage: 20,

    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']],

    operations: [

        new GetCollection(
            security: "is_granted('ROLE_ADMIN')",
            normalizationContext: ['groups' => ['client:list', 'client:read']]
        ),

        new Post(
            security: "is_granted('ROLE_ADMIN')",
        // processor: 'client.password_processor'
        ),

        new Get(
            security: "is_granted('ROLE_USER')"
        ),

        new Patch(
            security: "is_granted('ROLE_ADMIN')",
        // processor: 'client.password_processor'
        ),

        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'first_name' => 'partial',
    'last_name' => 'partial',
    'email' => 'exact',
])]
#[ApiFilter(OrderFilter::class, properties: ['id', 'last_name', 'email'])]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:list', 'client:read'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['client:write'])]
    private string $password;


    #[ORM\Column(type: 'json')]
    #[Groups(['client:read'])]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['client:list', 'client:read', 'client:write'])]
    private string $first_name;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['client:list', 'client:read', 'client:write'])]
    private string $last_name;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['client:list', 'client:read', 'client:write'])]
    private string $email;

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Groups(['client:list', 'client:read', 'client:write'])]
    private \DateTimeInterface $birth_date;

    #[ORM\OneToMany(targetEntity: Payments::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    #[Groups(['client:read'])]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: ClientPrograms::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    #[Groups(['client:read'])]
    private Collection $clientPrograms;

    #[ORM\OneToMany(targetEntity: ClientSession::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    #[Groups(['client:read'])]
    private Collection $clientSessions;

    #[ORM\OneToMany(targetEntity: Attendance::class, mappedBy: "client", cascade: ['persist', 'remove'])]
    #[Groups(['client:read'])]
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

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
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

    /**
     * @return Collection<int, Payments>
     */
    public function getPayments(): Collection {
        return $this->payments;
    }

    /**
     * @return Collection<int, ClientPrograms>
     */
    public function getClientPrograms(): Collection {
        return $this->clientPrograms;
    }

    /**
     * @return Collection<int, ClientSession>
     */
    public function getClientSessions(): Collection {
        return $this->clientSessions;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection {
        return $this->attendances;
    }
}