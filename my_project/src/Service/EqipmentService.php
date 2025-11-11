<?php

namespace App\Service;

use App\Entity\Eqipment;
use App\Service\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class EqipmentService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createEquipment(string $name, string $description): Eqipment
    {
        $e = $this->createEquipmentObject($name, $description);
        $this->requestChecker->validateRequestDataByConstraints($e);
        $this->em->persist($e);
        $this->em->flush();
        return $e;
    }

    private function createEquipmentObject(string $name, string $description): Eqipment
    {
        $e = new Eqipment();
        $e->setName($name)->setDescription($description);
        return $e;
    }

    public function updateEquipment(Eqipment $equipment, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($equipment, $method)) {
                $equipment->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($equipment);
        $this->em->flush();
    }

    public function deleteEquipment(Eqipment $equipment): void
    {
        $this->em->remove($equipment);
        $this->em->flush();
    }
}
