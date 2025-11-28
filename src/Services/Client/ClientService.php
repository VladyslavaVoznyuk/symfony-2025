<?php

namespace App\Services\Client;

use App\Entity\Client;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class ClientService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createClient(string $firstName, string $lastName, string $email, \DateTimeInterface $birthDate): Client
    {
        $client = $this->createClientObject($firstName, $lastName, $email, $birthDate);
        $this->requestChecker->validateRequestDataByConstraints($client);
        $this->em->persist($client);
        $this->em->flush();
        return $client;
    }

    private function createClientObject(string $firstName, string $lastName, string $email, \DateTimeInterface $birthDate): Client
    {
        $c = new Client();
        $c->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setBirthDate($birthDate);
        return $c;
    }

    public function updateClient(Client $client, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($client, $method)) {
                $client->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($client);
        $this->em->flush();
    }

    public function deleteClient(Client $client): void
    {
        $this->em->remove($client);
        $this->em->flush();
    }
}
