<?php

namespace App\Services\Payment;

use App\Entity\Client;
use App\Entity\Payments;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createPayment(Client $client, string $amount, \DateTimeInterface $paymentDate): Payments
    {
        $p = $this->createPaymentObject($client, $amount, $paymentDate);
        $this->requestChecker->validateRequestDataByConstraints($p);
        $this->em->persist($p);
        $this->em->flush();
        return $p;
    }

    private function createPaymentObject(Client $client, string $amount, \DateTimeInterface $paymentDate): Payments
    {
        $p = new Payments();
        $p->setClient($client)->setAmount($amount)->setPaymentDate($paymentDate);
        return $p;
    }

    public function updatePayment(Payments $payments, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($payments, $method)) {
                $payments->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($payments);
        $this->em->flush();
    }

    public function deletePayment(Payments $payments): void
    {
        $this->em->remove($payments);
        $this->em->flush();
    }
}
