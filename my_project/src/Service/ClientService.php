<?php

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class ClientService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Client::class)->findAll();
    }

    public function create(array $data): Client
    {
        $client = new Client();
        $client->setFirstName($data['first_name']);
        $client->setLastName($data['last_name']);
        $client->setEmail($data['email']);
        $client->setBirthDate(new \DateTime($data['birth_date']));
        $client->setPhone($data['phone']);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    public function update(int $id, array $data): ?Client
    {
        $client = $this->em->getRepository(Client::class)->find($id);
        if (!$client) return null;

        if (isset($data['first_name'])) $client->setFirstName($data['first_name']);
        if (isset($data['last_name'])) $client->setLastName($data['last_name']);
        if (isset($data['email'])) $client->setEmail($data['email']);
        if (isset($data['birth_date'])) $client->setBirthDate(new \DateTime($data['birth_date']));
        if (isset($data['phone'])) $client->setPhone($data['phone']);

        $this->em->flush();
        return $client;
    }

    public function delete(int $id): bool
    {
        $client = $this->em->getRepository(Client::class)->find($id);
        if (!$client) return false;

        $this->em->remove($client);
        $this->em->flush();
        return true;
    }
}
