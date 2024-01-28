<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use ProductManagement\Entity\Product;

readonly class CreateProductDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: Product::MAX_NAME_LENGTH)]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Type('float')]
        #[Assert\PositiveOrZero]
        public float  $price,

        #[Assert\NotBlank]
        #[Assert\Type('int')]
        #[Assert\PositiveOrZero]
        public int    $quantity,
    )
    {
    }
}