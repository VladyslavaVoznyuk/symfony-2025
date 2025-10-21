<?php

namespace App\Service;

use App\Entity\Programs;
use Doctrine\ORM\EntityManagerInterface;

class ProgramService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Programs::class)->findAll();
    }

    public function create(array $data): Programs
    {
        $program = new Programs();
        $program->setName($data['name']);
        $program->setDescription($data['description']);
        $program->setDurationWeeks($data['duration_weeks']);

        $this->em->persist($program);
        $this->em->flush();

        return $program;
    }

    public function update(int $id, array $data): ?Programs
    {
        $program = $this->em->getRepository(Programs::class)->find($id);
        if (!$program) return null;

        if (isset($data['name'])) $program->setName($data['name']);
        if (isset($data['description'])) $program->setDescription($data['description']);
        if (isset($data['duration_weeks'])) $program->setDurationWeeks($data['duration_weeks']);

        $this->em->flush();
        return $program;
    }

    public function delete(int $id): bool
    {
        $program = $this->em->getRepository(Programs::class)->find($id);
        if (!$program) return false;

        $this->em->remove($program);
        $this->em->flush();
        return true;
    }
}
