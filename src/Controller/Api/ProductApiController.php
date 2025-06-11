<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/products')]
class ProductApiController extends AbstractController
{
    #[Route('/', name: 'api_product_list', methods: ['GET'])]
    public function list(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'title' => $product->getTitle(),
                'price' => $product->getPrice(),
                'discount' => $product->getDiscount(),
                'quantity' => $product->getQuantity(),
                'soldQuantity' => $product->getSoldQuantity(),
                'unsoldQuantity' => $product->getUnsoldQuantity(),
                'priceAfterDiscount' => $product->getPriceAfterDiscount(),
                'totalPrice' => $product->getTotalPrice(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/', name: 'api_product_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setTitle($data['title']);
        $product->setPrice($data['price']);
        $product->setDiscount($data['discount'] ?? 0);
        $product->setQuantity($data['quantity']);
        $product->setSoldQuantity($data['soldQuantity'] ?? 0);

        $em->persist($product);
        $em->flush();

        return new JsonResponse(['status' => 'Product created'], 201);
    }

    #[Route('/{id}', name: 'api_product_show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        $data = [
            'id' => $product->getId(),
            'title' => $product->getTitle(),
            'price' => $product->getPrice(),
            'discount' => $product->getDiscount(),
            'quantity' => $product->getQuantity(),
            'soldQuantity' => $product->getSoldQuantity(),
            'unsoldQuantity' => $product->getUnsoldQuantity(),
            'priceAfterDiscount' => $product->getPriceAfterDiscount(),
            'totalPrice' => $product->getTotalPrice(),
        ];

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'api_product_update', methods: ['PUT'])]
    public function update(Product $product, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product->setTitle($data['title']);
        $product->setPrice($data['price']);
        $product->setDiscount($data['discount'] ?? 0);
        $product->setQuantity($data['quantity']);
        $product->setSoldQuantity($data['soldQuantity'] ?? 0);

        $em->flush();

        return new JsonResponse(['status' => 'Product updated']);
    }

    #[Route('/{id}', name: 'api_product_delete', methods: ['DELETE'])]
    public function delete(Product $product, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($product);
        $em->flush();

        return new JsonResponse(['status' => 'Product deleted']);
    }
}
