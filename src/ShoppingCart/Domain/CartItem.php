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

    public function toNative(): array
    {
        return [
            'product' => $this->product,
            'quantity' => $this->quantity
        ];
    }

    public static function fromNative(array $native): static
    {
        $product = new Product(
            $native['product']['sku'],
            $native['product']['name'],
            $native['product']['priceInCents'],
            $native['product']['url'],
            $native['product']['thumbnail'],
        );
        return new static($product, $native['quantity']);
    }
}