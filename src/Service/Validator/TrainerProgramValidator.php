<?php

namespace App\Service\Validator;

class TrainerProgramValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['trainer_id'])) && empty($data['trainer_id'])) {
            $errors[] = 'Trainer ID is required';
        }
        if (($requireAllFields || isset($data['program_id'])) && empty($data['program_id'])) {
            $errors[] = 'Program ID is required';
        }
        return $errors;
    }
}
