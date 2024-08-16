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

    #[Route('/cart/{product}', name: 'add_to_cart', methods: ['PUT'])]
    public function addToCart(Request $request, Product $product)
    {
        $shoppingCart = $this->entityManager->getRepository(ShoppingCart::class)->find(1);

        $cartItem = new CartItem();
        $cartItem->addProduct($product);
        $cartItem->setQuantity($request->getPayload()->get('quantity', 1));
        $cartItem = $shoppingCart->addCartItem($cartItem);

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
        
        return $this->json([
            'item' => $cartItem->toArray(),
        ]);
    }

    #[Route('/cart/{product}', name: 'remove_from_cart', methods: ['DELETE'])]
    public function removeFromCart(Request $request, Product $product)
    {
        $shoppingCart = $this->entityManager->getRepository(ShoppingCart::class)->find(1);

        $cartItem = new CartItem();
        $cartItem->addProduct($product);
        $cartItem->setQuantity($request->getPayload()->get('quantity', 1));
        $cartItem = $shoppingCart->removeCartItem($cartItem);

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
        
        return $this->json([
            'item' => $cartItem->toArray(),
        ]);
    }
}