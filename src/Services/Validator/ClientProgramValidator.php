<?php

namespace App\Services\Validator;

class ClientProgramValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['client_id'])) && empty($data['client_id'])) {
            $errors[] = 'Client ID is required';
        }
        if (($requireAllFields || isset($data['program_id'])) && empty($data['program_id'])) {
            $errors[] = 'Program ID is required';
        }
        if (($requireAllFields || isset($data['start_date'])) && !empty($data['start_date']) && !strtotime($data['start_date'])) {
            $errors[] = 'Invalid start date';
        }
        return $errors;
    }
}
