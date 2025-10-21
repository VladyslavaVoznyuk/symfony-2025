<?php

namespace App\Service;

use App\Entity\ClientPrograms;
use Doctrine\ORM\EntityManagerInterface;

class ClientProgramsService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(ClientPrograms::class)->findAll();
    }

    public function create(array $data): ClientPrograms
    {
        $cp = new ClientPrograms();
        $cp->setClientId($data['client_id']);
        $cp->setProgramId($data['program_id']);
        $cp->setStartDate(new \DateTime($data['start_date']));

        $this->em->persist($cp);
        $this->em->flush();

        return $cp;
    }

    public function update(int $id, array $data): ?ClientPrograms
    {
        $cp = $this->em->getRepository(ClientPrograms::class)->find($id);
        if (!$cp) return null;

        if (isset($data['client_id'])) $cp->setClientId($data['client_id']);
        if (isset($data['program_id'])) $cp->setProgramId($data['program_id']);
        if (isset($data['start_date'])) $cp->setStartDate(new \DateTime($data['start_date']));

        $this->em->flush();
        return $cp;
    }

    public function delete(int $id): bool
    {
        $cp = $this->em->getRepository(ClientPrograms::class)->find($id);
        if (!$cp) return false;

        $this->em->remove($cp);
        $this->em->flush();
        return true;
    }
}
