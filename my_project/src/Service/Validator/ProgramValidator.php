<?php

namespace App\Service\Validator;

class ProgramValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['name'])) && empty($data['name'])) {
            $errors[] = 'Program name is required';
        }
        if (($requireAllFields || isset($data['duration_weeks'])) && (!is_numeric($data['duration_weeks'] ?? null) || $data['duration_weeks'] <= 0)) {
            $errors[] = 'Duration weeks must be a positive number';
        }
        return $errors;
    }
}
