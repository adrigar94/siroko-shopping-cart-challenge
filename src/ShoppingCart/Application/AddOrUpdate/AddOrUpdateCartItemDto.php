<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate;

class AddOrUpdateCartItemDto
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly int $priceInCents,
        public readonly string $url,
        public readonly string $thumbnail,
        public readonly int $quantity
    ) {
    }
}