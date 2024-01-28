<?php

declare(strict_types=1);

namespace App\DataMapper;

use ProductManagement\Dto\ProductDto;
use ProductManagement\Entity\Product;

class ProductMapper
{
    /**
     * Maps a product entity to a DTO.
     *
     * @param Product $product
     *
     * @return ProductDto
     */
    public function mapProductToDto(Product $product): ProductDto
    {
        return new ProductDto(
            $product->getId(),
            $product->getName(),
            $product->getPrice(),
            $product->getQuantity(),
        );
    }

    /**
     * Maps an array of product entities to a DTO array.
     *
     * @param Product[] $products
     *
     * @return ProductDto[]
     */
    public function mapProductsToDtos(array $products): array
    {
        return array_map([$this, 'mapProductToDto'], $products);
    }
}
