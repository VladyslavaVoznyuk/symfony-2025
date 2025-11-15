<?php

namespace App\Service\Validator;

class PaymentValidator
{
    public function validate(array $data, bool $requireAllFields = true): array
    {
        $errors = [];
        if (($requireAllFields || isset($data['client_id'])) && empty($data['client_id'])) {
            $errors[] = 'Client ID is required';
        }
        if (($requireAllFields || isset($data['amount'])) && (!is_numeric($data['amount']) || $data['amount'] <= 0)) {
            $errors[] = 'Amount must be a positive number';
        }
        if (($requireAllFields || isset($data['payment_date'])) && !empty($data['payment_date']) && !strtotime($data['payment_date'])) {
            $errors[] = 'Invalid payment date';
        }
        if (($requireAllFields || isset($data['method'])) && empty($data['method'])) {
            $errors[] = 'Payment method is required';
        }
        return $errors;
    }
}
