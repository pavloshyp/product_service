<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Validator\UuidValidator;
use App\Exception\ProductNotFoundException;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Dto\CreateProductDto;

#[Route(path: '/api/v1')]
class ProductApiController extends AbstractController
{
    public function __construct(
        private readonly ProductServiceInterface $productService,
        private readonly UuidValidator           $uuidValidator,
    ) {
    }

    #[Route('/products', name: 'product_create_v1', methods: ['POST'])]
    public function v1Create(#[MapRequestPayload] CreateProductDto $createProductDto): Response
    {
        $product = $this->productService->createProduct($createProductDto);

        return new JsonResponse($product, Response::HTTP_CREATED);
    }

    #[Route('/products', name: 'product_list_v1', methods: ['GET'])]
    public function v1List(): JsonResponse
    {
        $products = $this->productService->getProducts();

        return new JsonResponse(['data' => $products]);
    }

    #[Route('/products/{id}', name: 'product_get_v1', methods: ['GET'])]
    public function v1Get(string $id): JsonResponse
    {
        $errors = $this->uuidValidator->validate($id);
        if (!empty($errors)) {
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }

        try {
            $product = $this->productService->getProduct($id);
        } catch (ProductNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($product);
    }
}

