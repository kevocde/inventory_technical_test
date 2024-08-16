<?php

namespace App\Service;

use App\Entity\CountableProduct;
use App\Entity\Product;
use App\Entity\WeightedProduct;
use Doctrine\ORM\EntityManagerInterface;

class ProductFactory
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {
    }

    public function getProductById(int $id): Product
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        
        return ($product->isWeighted()) ? 
            WeightedProduct::getProductInstance($product) : 
            CountableProduct::getProductInstance($product)
        ;
    }
}