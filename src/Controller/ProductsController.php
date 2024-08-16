<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/products', name: 'product', methods: ['GET'])]
    public function index()
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->json([
            'items' => array_map(fn(Product $product) => $product->toArray(), $products),
        ]);
    }

    #[Route('/products/{product}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product)
    {
        return $this->json([
            'item' => $product->toArray(),  
        ]);
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(Request $request)
    {
        $payload = $request->getPayload();

        $product = new Product();
        $product->setName($payload->get('name'));
        $product->setPrice($payload->get('price'));
        $product->setUnits($payload->get('units'));
        $product->setWeighted($payload->get('weighted'));
        
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->json([
            'item' => $product->toArray(),
            'message' => 'Product created successfully',
        ]);
    }

    #[Route('/products/{product}', name: 'product_edit', methods: ['PUT'])]
    public function edit(Request $request, Product $product)
    {
        $properties = $request->getPayload()->all();
        foreach ($properties as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($product, $setter)) {
                $product->$setter($value);
            }
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this->json([
            'item' => $product->toArray(),
            'message' => 'Product updated successfully',
        ]);
    }

    #[Route('/products/{product}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Product deleted successfully',
        ]);
    }
}