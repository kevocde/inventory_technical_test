<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class InventoryService
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {
    }
}