<?php

namespace App\Entity;

class WeightedProduct extends Product
{
    const DISCONT = 10;

    public function getTotalByQuantity(int $quantity): float
    {
        $price = $this->getPrice();

        if ($quantity >= 10) {
            $price -= $price * (self::DISCONT / 100);
        }

        return $price * $quantity;
    }
}