<?php

namespace App\Services\Trainer;

use App\Entity\Trainers;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class TrainerService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createTrainer(string $firstName, string $lastName, string $email, string $specialty, string $phone): Trainers
    {
        $t = $this->createTrainerObject($firstName, $lastName, $email, $specialty, $phone);
        $this->requestChecker->validateRequestDataByConstraints($t);
        $this->em->persist($t);
        $this->em->flush();
        return $t;
    }

    private function createTrainerObject(string $firstName, string $lastName, string $email, string $specialty, string $phone): Trainers
    {
        $t = new Trainers();
        $t->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setSpecialty($specialty)
            ->setPhone($phone);
        return $t;
    }

    public function updateTrainer(Trainers $trainer, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($trainer, $method)) {
                $trainer->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($trainer);
        $this->em->flush();
    }

    public function deleteTrainer(Trainers $trainer): void
    {
        $this->em->remove($trainer);
        $this->em->flush();
    }
}
