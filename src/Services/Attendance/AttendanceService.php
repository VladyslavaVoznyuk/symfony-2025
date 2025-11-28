<?php

namespace App\Services\Attendance;

use App\Entity\Attendance;
use App\Entity\Client;
use App\Entity\Session;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class AttendanceService
{
    private EntityManagerInterface $em;
    private RequestCheckerService $requestChecker;

    public function __construct(EntityManagerInterface $em, RequestCheckerService $requestChecker)
    {
        $this->em = $em;
        $this->requestChecker = $requestChecker;
    }

    public function createAttendance(Client $client, Session $session, string $attended): Attendance
    {
        $a = $this->createAttendanceObject($client, $session, $attended);
        $this->requestChecker->validateRequestDataByConstraints($a);
        $this->em->persist($a);
        $this->em->flush();
        return $a;
    }

    private function createAttendanceObject(Client $client, Session $session, string $attended): Attendance
    {
        $a = new Attendance();
        $a->setClient($client)
            ->setSession($session)
            ->setAttended($attended);
        return $a;
    }

    public function updateAttendance(Attendance $attendance, array $data): void
    {
        foreach ($data as $k => $v) {
            $method = 'set' . str_replace('_', '', ucwords($k, '_'));
            if (method_exists($attendance, $method)) {
                $attendance->$method($v);
            }
        }
        $this->requestChecker->validateRequestDataByConstraints($attendance);
        $this->em->flush();
    }

    public function deleteAttendance(Attendance $attendance): void
    {
        $this->em->remove($attendance);
        $this->em->flush();
    }
}
