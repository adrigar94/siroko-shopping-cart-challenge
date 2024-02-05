<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

class Product
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly float $price
    ) {
    }
}