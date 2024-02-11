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

    public function toNative(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'priceInCents' => $this->priceInCents,
            'url' => $this->url,
            'thumbnail' => $this->thumbnail,
        ];
    }
}