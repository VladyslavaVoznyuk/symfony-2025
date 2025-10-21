<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $first_name;

    #[ORM\Column(length: 255)]
    private string $last_name;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(type: "date")]
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

    public function getFirstName(): string
    {
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
    public function addPayment(Payments $payment): void
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setClient($this);
        }
    }

    public function getClientPrograms(): Collection {
        return $this->clientPrograms;
    }
    public function addClientProgram(ClientPrograms $clientProgram): void
    {
        if (!$this->clientPrograms->contains($clientProgram)) {
            $this->clientPrograms->add($clientProgram);
            $clientProgram->setClient($this);
        }
    }

    public function getClientSessions(): Collection {
        return $this->clientSessions;
    }
    public function addClientSession(ClientSession $clientSession): void
    {
        if (!$this->clientSessions->contains($clientSession)) {
            $this->clientSessions->add($clientSession);
            $clientSession->setClient($this);
        }
    }

    public function getAttendances(): Collection {
        return $this->attendances;
    }
    public function addAttendance(Attendance $attendance): void
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances->add($attendance);
            $attendance->setClient($this);
        }
    }
}
