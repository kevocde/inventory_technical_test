<?php

namespace DDD\Domain\Entities;

class CountableProduct extends Product
{
    public function __construct(
        int $id,
        string $name,
        float $price,
        string $units,
        bool $weighted
    )
    {
        parent::__construct($id, $name, $price, $units, $weighted);
    }
}