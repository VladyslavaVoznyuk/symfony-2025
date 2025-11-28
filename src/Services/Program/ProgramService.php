<?php

namespace App\Services\Program;

use App\Entity\Programs;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class ProgramService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createProgram(string $name, string $description, int $durationWeeks): Programs
    {
        $p = $this->createProgramObject($name, $description, $durationWeeks);
        $this->requestChecker->validateRequestDataByConstraints($p);
        $this->em->persist($p);
        $this->em->flush();
        return $p;
    }

    private function createProgramObject(string $name, string $description, int $durationWeeks): Programs
    {
        $p = new Programs();
        $p->setName($name)
            ->setDescription($description)
            ->setDurationWeeks((string)$durationWeeks);
        return $p;
    }

    public function updateProgram(Programs $program, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($program, $method)) {
                $program->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($program);
        $this->em->flush();
    }

    public function deleteProgram(Programs $program): void
    {
        $this->em->remove($program);
        $this->em->flush();
    }
}
