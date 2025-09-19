<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private array $products = [
        1 => 'Торт Київський',
        2 => 'Торт Наполеон',
        3 => 'Торт Медовик',
    ];

    //браузер
    #[Route('/product', name: 'product_index_browser', methods: ['GET'])]
    public function indexBrowser(): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $this->products,
        ]);
    }

    #[Route('/api/products', name: 'product_index', methods: ['GET'])]
    public function indexApi(): JsonResponse
    {
        return $this->json($this->products);
    }

    #[Route('/api/products', name: 'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? 'Новий торт';

        $newId = count($this->products) + 1;
        $this->products[$newId] = $name;

        return $this->json([
            'message' => 'Продукт створено',
            'id' => $newId,
            'name' => $name,
        ]);
    }

    #[Route('/api/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        if (!isset($this->products[$id])) {
            return $this->json(['error' => 'Продукт не знайдено'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $this->products[$id] = $data['name'] ?? $this->products[$id];

        return $this->json([
            'message' => 'Продукт оновлено',
            'id' => $id,
            'name' => $this->products[$id],
        ]);
    }

    #[Route('/api/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!isset($this->products[$id])) {
            return $this->json(['error' => 'Продукт не знайдено'], 404);
        }

        unset($this->products[$id]);

        return $this->json([
            'message' => 'Продукт видалено',
            'id' => $id,
        ]);
    }
}
