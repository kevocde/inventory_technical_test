<?php

namespace DDD\Application\UseCases;

class ListProductsUseCase
{
    public function __construct()
    {
    }

    public function execute(): array
    {
        return [
            'products' => [],
        ];
    }
}