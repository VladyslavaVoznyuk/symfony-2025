<?php

namespace App\Services\Session;

use App\Entity\Programs;
use App\Entity\Session;
use App\Entity\Trainers;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class SessionService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createSession(\DateTimeInterface $sessionDate, string $durationMinutes, Programs $program, Trainers $trainer): Session
    {
        $s = $this->createSessionObject($sessionDate, $durationMinutes, $program, $trainer);
        $this->requestChecker->validateRequestDataByConstraints($s);
        $this->em->persist($s);
        $this->em->flush();
        return $s;
    }

    private function createSessionObject(\DateTimeInterface $sessionDate, string $durationMinutes, Programs $program, Trainers $trainer): Session
    {
        $s = new Session();
        $s->setSessionDate($sessionDate)
            ->setDurationMinutes($durationMinutes)
            ->setProgram($program)
            ->setTrainer($trainer);
        return $s;
    }

    public function updateSession(Session $session, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($session, $method)) {
                $session->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($session);
        $this->em->flush();
    }

    public function deleteSession(Session $session): void
    {
        $this->em->remove($session);
        $this->em->flush();
    }
}
