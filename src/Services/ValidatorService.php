<?php

namespace App\Services;

class ValidatorService
{
    public function validateClient(array $data): array
    {
        $errors = [];
        if (empty($data['first_name'])) {
            $errors[] = 'First name is required';
        }
        if (empty($data['last_name'])) {
            $errors[] = 'Last name is required';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email';
        }
        return $errors;
    }
}
