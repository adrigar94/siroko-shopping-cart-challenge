<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Ramsey\Uuid\Uuid;

class CartMother
{
    public static function createEmpty(): Cart
    {
        return Cart::create(
            Uuid::uuid4()->__toString(),
            Uuid::uuid4()->__toString()
        );
    }

    public static function createOpenWithProducts(): Cart
    {
        $cart = Cart::create(
            Uuid::uuid4()->__toString(),
            Uuid::uuid4()->__toString()
        );

        $cart->upsertItem(CartItemMother::create(1));
        $cart->upsertItem(CartItemMother::create(2));

        return $cart;
    }
}