<?php

namespace DDD\Domain\Entities;

class WeightedProduct extends Product
{
    const DISCOUNT = 0.9;

    public function __construct(
        int $id,
        string $name,
        float $price,
        string $units,
        bool $weighted,
        private float $weight
    )
    {
        parent::__construct($id, $name, $price, $units, $weighted);
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;
        return $this;
    }

    public function calTotalByQuantity(int $quantity): float
    {
        $price = $this->getPrice();

        if ($quantity > 10) {
            $price = $price * 0.9;
        }

        return $price * $quantity;
    }
}