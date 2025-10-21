<?php

namespace App\Service;

use App\Entity\Payments;
use Doctrine\ORM\EntityManagerInterface;

class PaymentServices
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAll(): array
    {
        return $this->em->getRepository(Payments::class)->findAll();
    }

    public function create(array $data): Payments
    {
        $payment = new Payments();
        $payment->setClientId($data['client_id']);
        $payment->setAmount($data['amount']);
        $payment->setPaymentDate(new \DateTime($data['date']));

        $this->em->persist($payment);
        $this->em->flush();

        return $payment;
    }

    public function update(int $id, array $data): ?Payments
    {
        $payment = $this->em->getRepository(Payments::class)->find($id);
        if (!$payment) return null;

        if (isset($data['client_id'])) $payment->setClientId($data['client_id']);
        if (isset($data['amount'])) $payment->setAmount($data['amount']);
        if (isset($data['date'])) $payment->setDate(new \DateTime($data['date']));

        $this->em->flush();
        return $payment;
    }

    public function delete(int $id): bool
    {
        $payment = $this->em->getRepository(Payments::class)->find($id);
        if (!$payment) return false;

        $this->em->remove($payment);
        $this->em->flush();
        return true;
    }
}
