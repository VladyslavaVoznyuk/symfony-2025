<?php

namespace App\Services;

use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Service for validating incoming request data.
 */
class RequestCheckerService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Checks that the given content contains all required fields.
     *
     * @param mixed $content
     * @param array $fields
     * @return bool
     * @throws Exception
     */
    public function check(mixed $content, array $fields): bool
    {
        $errors = '';

        if (!isset($content) || empty($content)) {
            throw new BadRequestException('Empty content', Response::HTTP_BAD_REQUEST);
        }

        foreach ($fields as $field) {
            if (!isset($content[$field])) {
                $errors .= ' ' . $field . ';';
            }
        }

        if ($errors) {
            throw new BadRequestException(
                'Required fields are missing: ' . trim($errors),
                Response::HTTP_BAD_REQUEST
            );
        }

        return true;
    }

    /**
     * Validates request data using Symfony constraints.
     *
     * @param array|object $data
     * @param array|null $constraints
     * @param bool|null $removeSquareBracketFromPropertyPath
     * @return void
     */
    public function validateRequestDataByConstraints(
        array|object $data,
        ?array $constraints = null,
        ?bool $removeSquareBracketFromPropertyPath = false
    ): void {
        $errors = $this->validator->validate(
            $data,
            !empty($constraints) ? new Collection($constraints) : null
        );

        if (count($errors) === 0) {
            return;
        }

        $validationErrors = [];

        foreach ($errors as $error) {
            $key = $error->getPropertyPath();

            if ($removeSquareBracketFromPropertyPath) {
                $key = preg_replace('/\[.*?\]/', '', $key);
            } else {
                $key = str_replace(['[', ']'], ['', ''], $key);
            }

            $validationErrors[$key] = $error->getMessage();
        }

        throw new UnprocessableEntityHttpException(json_encode([
            'data' => [
                'errors' => $validationErrors,
            ],
        ]));
    }
}
