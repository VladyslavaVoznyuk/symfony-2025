<?php

namespace App\Service\Validator;

class TrainerValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['first_name'])) && empty($data['first_name'])) {
            $errors[] = 'First name is required';
        }
        if (($requireAllFields || isset($data['last_name'])) && empty($data['last_name'])) {
            $errors[] = 'Last name is required';
        }
        if (($requireAllFields || isset($data['email'])) && !filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }
        if (($requireAllFields || isset($data['specialty'])) && empty($data['specialty'])) {
            $errors[] = 'Specialty is required';
        }
        return $errors;
    }
}
