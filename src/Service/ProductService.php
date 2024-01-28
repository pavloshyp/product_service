<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateProductDto;
use App\Exception\ProductNotFoundException;
use Symfony\Component\Messenger\MessageBusInterface;
use ProductManagement\Message\ProductMessage;
use ProductManagement\Entity\Product;
use App\Repository\ProductRepositoryInterface;
use ProductManagement\Dto\ProductDto;
use App\DataMapper\ProductMapper;

readonly class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private MessageBusInterface        $messageBus,
        private ProductMapper              $productMapper,
    )
    {
    }

    /**
     * @inheritdoc
     */
    public function getProducts(): array
    {
        $products = $this->productRepository->findAll();

        return $this->productMapper->mapProductsToDtos($products);
    }

    /**
     * @inheritdoc
     * @throws ProductNotFoundException
     */
    public function getProduct(string $id): ProductDto
    {
        $product = $this->productRepository->find($id);
        if (!$product) {
            throw new ProductNotFoundException(sprintf('Product with id %s not found', $id));
        }

        return $this->productMapper->mapProductToDto($product);
    }

    /**
     * @inheritdoc
     */
    public function createProduct(CreateProductDto $productData): ProductDto
    {
        $product = new Product();
        $product->setName($productData->name);
        $product->setPrice($productData->price);
        $product->setQuantity($productData->quantity);

        $this->productRepository->save($product);

        $productDto = $this->productMapper->mapProductToDto($product);

        $this->messageBus->dispatch(new ProductMessage($productDto));

        return $productDto;
    }
}

