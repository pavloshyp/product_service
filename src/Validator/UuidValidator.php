<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Utils\ValidationErrorFormatter;

readonly class UuidValidator
{
    public function __construct(
        private ValidatorInterface $validator)
    {
    }

    public function validate(string $uuid): array
    {
        $constraints = new Assert\Uuid();
        $errors = $this->validator->validate($uuid, $constraints);

        return ValidationErrorFormatter::formatErrors($errors);
    }
}