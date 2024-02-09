<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

class CartItem
{
    public function __construct(
        public readonly Product $product,
        public readonly int $quantity
    ) {
    }

    public function productId(): string
    {
        return $this->product->sku;
    }
}