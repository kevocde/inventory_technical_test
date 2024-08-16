<?php

namespace DDD\Domain\Entities;

abstract class Product
{
    public function __construct(
        private int $id,
        private string $name,
        private float $price,
        private string $units,
        private bool $weighted
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getUnits(): string
    {
        return $this->units;
    }

    public function isWeighted(): bool
    {
        return $this->weighted;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function setUnits(string $units): static
    {
        $this->units = $units;
        return $this;
    }

    public function setWeighted(bool $weighted): static
    {
        $this->weighted = $weighted;
        return $this;
    }

    public function calTotalByQuantity(int $quantity): float
    {
        return $this->getPrice() * $quantity;
    }
}