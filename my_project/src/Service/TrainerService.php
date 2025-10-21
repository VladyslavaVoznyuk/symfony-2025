<?php

namespace App\Service;

use App\Entity\Trainers;
use Doctrine\ORM\EntityManagerInterface;

class TrainerService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Trainers::class)->findAll();
    }

    public function create(array $data): Trainers
    {
        $trainer = new Trainers();
        $trainer->setFirstName($data['first_name']);
        $trainer->setLastName($data['last_name']);
        $trainer->setEmail($data['email']);

        $this->em->persist($trainer);
        $this->em->flush();

        return $trainer;
    }

    public function update(int $id, array $data): ?Trainers
    {
        $trainer = $this->em->getRepository(Trainers::class)->find($id);
        if (!$trainer) return null;

        if (isset($data['first_name'])) $trainer->setFirstName($data['first_name']);
        if (isset($data['last_name'])) $trainer->setLastName($data['last_name']);
        if (isset($data['email'])) $trainer->setEmail($data['email']);

        $this->em->flush();
        return $trainer;
    }

    public function delete(int $id): bool
    {
        $trainer = $this->em->getRepository(Trainers::class)->find($id);
        if (!$trainer) return false;

        $this->em->remove($trainer);
        $this->em->flush();
        return true;
    }
}
