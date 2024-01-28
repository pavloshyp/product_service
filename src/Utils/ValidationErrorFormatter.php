<?php

declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorFormatter
{
    public static function formatErrors(ConstraintViolationListInterface $errors): array
    {
        $formattedErrors = [];
        foreach ($errors as $error) {
            $formattedErrors[] = [
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }

        return $formattedErrors;
    }
}