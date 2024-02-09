<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

class Product
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly int $priceInCents,
        public readonly string $url,
        public readonly string $thumbnail,
    ) {
    }
}