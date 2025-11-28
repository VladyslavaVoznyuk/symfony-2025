<?php

namespace App\Services\Validator;

class EqipmentValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['name'])) && empty($data['name'])) {
            $errors[] = 'Equipment name is required';
        }
        if (($requireAllFields || isset($data['type'])) && empty($data['type'])) {
            $errors[] = 'Equipment type is required';
        }
        if (($requireAllFields || isset($data['purchase_date'])) && !empty($data['purchase_date']) && !strtotime($data['purchase_date'])) {
            $errors[] = 'Invalid purchase date';
        }
        if (($requireAllFields || isset($data['status'])) && empty($data['status'])) {
            $errors[] = 'Equipment status is required';
        }
        return $errors;
    }
}
