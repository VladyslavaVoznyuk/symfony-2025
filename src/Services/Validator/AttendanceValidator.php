<?php

namespace App\Services\Validator;

class AttendanceValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['client_id'])) && empty($data['client_id'])) {
            $errors[] = 'Client ID is required';
        }
        if (($requireAllFields || isset($data['session_id'])) && empty($data['session_id'])) {
            $errors[] = 'Session ID is required';
        }
        if (($requireAllFields || isset($data['status'])) && empty($data['status'])) {
            $errors[] = 'Attendance status is required';
        }
        return $errors;
    }
}
