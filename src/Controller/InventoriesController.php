<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inventories', name: 'inventory_')]
class InventoriesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index()
    {
        $inventories = $this->entityManager->getRepository(Inventory::class)->findAll();

        return $this->json([
            'items' => array_map(fn(Inventory $inventory) => $inventory->toArray(), $inventories),
        ]);
    }

    #[Route('/{inventory}', name: 'show', methods: ['GET'])]
    public function show(Inventory $inventory)
    {
        return $this->json([
            'item' => $inventory->toArray(),  
        ]);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request)
    {
        $payload = $request->getPayload()->all();
        $productPayload = $payload['product'];

        $product = new Product();
        $product->setName($productPayload['name']);
        $product->setPrice($productPayload['price']);
        $product->setUnits($productPayload['unit']);
        $product->setWeighted($productPayload['weighted']);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $inventory = new Inventory();
        $inventory->setProduct($product);
        $inventory->setQuantity($payload['quantity']);
        
        $this->entityManager->persist($inventory);
        $this->entityManager->flush();

        return $this->json([
            'item' => $inventory->toArray(),
            'message' => 'Inventory created successfully',
        ]);
    }

    #[Route('/{inventory}', name: 'edit', methods: ['PUT'])]
    public function edit(Request $request, Inventory $inventory)
    {
        $properties = $request->getPayload()->all();
        foreach ($properties as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($inventory, $setter)) {
                $inventory->$setter($value);
            }
        }

        $this->entityManager->persist($inventory);
        $this->entityManager->flush();

        return $this->json([
            'item' => $inventory->toArray(),
            'message' => 'Inventory updated successfully',
        ]);
    }

    #[Route('/{inventory}', name: 'delete', methods: ['DELETE'])]
    public function delete(Inventory $inventory)
    {
        $this->entityManager->remove($inventory);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Inventory deleted successfully',
        ]);
    }
}