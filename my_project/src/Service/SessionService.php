<?php

namespace App\Service;

use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class SessionService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Session::class)->findAll();
    }

    public function create(array $data): Session
    {
        $session = new Session();

        $session->setProgramId($data['program_id']);
        $session->setTrainerId($data['trainer_id']);
        $session->setSessionDate(new \DateTime($data['session_date']));
        $session->setDurationMinutes($data['duration_minutes']);

        $this->em->persist($session);
        $this->em->flush();

        return $session;
    }

    public function update(int $id, array $data): ?Session
    {
        $session = $this->em->getRepository(Session::class)->find($id);
        if (!$session) {
            return null;
        }

        if (isset($data['program_id'])) {
            $session->setProgramId($data['program_id']);
        }

        if (isset($data['trainer_id'])) {
            $session->setTrainerId($data['trainer_id']);
        }

        if (isset($data['session_date'])) {
            $session->setSessionDate(new \DateTime($data['session_date']));
        }

        if (isset($data['duration_minutes'])) {
            $session->setDurationMinutes($data['duration_minutes']);
        }

        $this->em->flush();

        return $session;
    }

    public function delete(int $id): bool
    {
        $session = $this->em->getRepository(Session::class)->find($id);
        if (!$session) {
            return false;
        }

        $this->em->remove($session);
        $this->em->flush();

        return true;
    }

    public function getById(int $id): ?Session
    {
        return $this->em->getRepository(Session::class)->find($id);
    }
}
