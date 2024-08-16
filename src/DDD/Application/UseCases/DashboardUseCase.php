<?php

namespace DDD\Application\UseCases;

class DashboardUseCase
{
    public function __construct()
    {
    }

    public function execute(): array
    {
        return [
            'products' => [],
            'shoppingCart' => [
                'products' => [],
                'total' => 0,
            ],
        ];
    }
}