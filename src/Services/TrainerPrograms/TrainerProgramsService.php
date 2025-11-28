<?php

namespace App\Services\TrainerPrograms;

use App\Entity\Programs;
use App\Entity\TrainerPrograms;
use App\Entity\Trainers;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class TrainerProgramsService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createTrainerProgram(Trainers $trainer, Programs $program): TrainerPrograms
    {
        $tp = $this->createTrainerProgramObject($trainer, $program);
        $this->requestChecker->validateRequestDataByConstraints($tp);
        $this->em->persist($tp);
        $this->em->flush();
        return $tp;
    }

    private function createTrainerProgramObject(Trainers $trainer, Programs $program): TrainerPrograms
    {
        $tp = new TrainerPrograms();
        $tp->setTrainer($trainer)->setProgram($program);
        return $tp;
    }

    public function updateTrainerProgram(TrainerPrograms $tp, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($tp, $method)) {
                $tp->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($tp);
        $this->em->flush();
    }

    public function deleteTrainerProgram(TrainerPrograms $tp): void
    {
        $this->em->remove($tp);
        $this->em->flush();
    }
}
