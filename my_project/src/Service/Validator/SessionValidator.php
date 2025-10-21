<?php

namespace App\Service\Validator;

class SessionValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['program_id'])) && empty($data['program_id'])) {
            $errors[] = 'Program ID is required';
        }
        if (($requireAllFields || isset($data['trainer_id'])) && empty($data['trainer_id'])) {
            $errors[] = 'Trainer ID is required';
        }
        if (($requireAllFields || isset($data['session_date'])) && !empty($data['session_date']) && !strtotime($data['session_date'])) {
            $errors[] = 'Invalid session date';
        }
        if (($requireAllFields || isset($data['time'])) && empty($data['time'])) {
            $errors[] = 'Session time is required';
        }
        return $errors;
    }
}
