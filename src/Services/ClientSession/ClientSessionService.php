<?php

namespace App\Services\ClientSession;

use App\Entity\Client;
use App\Entity\ClientSession;
use App\Entity\Session;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class ClientSessionService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createClientSession(Client $client, Session $session): ClientSession
    {
        $cs = $this->createClientSessionObject($client, $session);
        $this->requestChecker->validateRequestDataByConstraints($cs);
        $this->em->persist($cs);
        $this->em->flush();
        return $cs;
    }

    private function createClientSessionObject(Client $client, Session $session): ClientSession
    {
        $cs = new ClientSession();
        $cs->setClient($client)->setSession($session);
        return $cs;
    }

    public function updateClientSession(ClientSession $cs, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($cs, $method)) {
                $cs->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($cs);
        $this->em->flush();
    }

    public function deleteClientSession(ClientSession $cs): void
    {
        $this->em->remove($cs);
        $this->em->flush();
    }
}
