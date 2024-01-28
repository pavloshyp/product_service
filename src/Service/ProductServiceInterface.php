<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateProductDto;
use ProductManagement\Dto\ProductDto;

interface ProductServiceInterface
{
    /**
     * Get a list of products.
     *
     * @return ProductDto[]
     */
    public function getProducts(): array;

    /**
     * Get a single product by its ID.
     *
     * @param string $id The ID of the product to retrieve.
     * @return ProductDto The requested product.
     */
    public function getProduct(string $id): ProductDto;

    /**
     * Create a new product.
     *
     * @param CreateProductDto $productData The data used to create a new product.
     * @return ProductDto The created product's data transfer object.
     */
    public function createProduct(CreateProductDto $productData): ProductDto;
}
