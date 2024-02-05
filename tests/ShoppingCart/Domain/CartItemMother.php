<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartItem;

class CartItemMother
{
    public static function create(int $quantity = 1): CartItem
    {
        $product = ProductMother::random();
        return new CartItem($product, $quantity);
    }
}