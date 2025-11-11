<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\ClientPrograms;
use App\Entity\Programs;
use App\Service\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class ClientProgramsService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createClientProgram(Client $client, Programs $program, \DateTimeInterface $startDate, \DateTimeInterface $endDate): ClientPrograms
    {
        $cp = $this->createClientProgramObject($client, $program, $startDate, $endDate);
        $this->requestChecker->validateRequestDataByConstraints($cp);
        $this->em->persist($cp);
        $this->em->flush();
        return $cp;
    }

    private function createClientProgramObject(Client $client, Programs $program, \DateTimeInterface $startDate, \DateTimeInterface $endDate): ClientPrograms
    {
        $cp = new ClientPrograms();
        $cp->setClient($client)
            ->setProgram($program)
            ->setStartDate($startDate)
            ->setEndDate($endDate);
        return $cp;
    }

    public function updateClientProgram(ClientPrograms $cp, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($cp, $method)) {
                $cp->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($cp);
        $this->em->flush();
    }

    public function deleteClientProgram(ClientPrograms $cp): void
    {
        $this->em->remove($cp);
        $this->em->flush();
    }
}
