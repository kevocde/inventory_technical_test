<?php

namespace App\Entity;

class WeightedProduct extends Product
{
    const DISCONT = 10;

    public function getTotalByQuantity(int $quantity): float
    {
        return ($this->getPrice() * $quantity) * (1 + (self::DISCONT / 100));
    }
}