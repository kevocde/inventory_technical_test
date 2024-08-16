<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/', name: 'dashboard')]
    public function index()
    {
        $inventories = $this->entityManager->getRepository(Inventory::class)->findAll();
        $shoppingCart = $this->entityManager->getRepository(ShoppingCart::class)->find(1);
        

        return $this->json([
            'products' => [
                'items' => array_map(fn(Inventory $inventory) => $inventory->toArray(), $inventories),
            ],
            'shoppingCart' => $shoppingCart->toArray(),
        ]);
    }

    
}