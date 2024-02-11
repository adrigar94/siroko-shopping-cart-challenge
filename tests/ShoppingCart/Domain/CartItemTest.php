<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartItem;
use PHPUnit\Framework\TestCase;

class CartItemTest extends TestCase
{

    public function testCreateCartItem()
    {
        $cart = CartItemMother::create();
        $this->assertInstanceOf(CartItem::class, $cart);
    }


    public function testCartItemToNative()
    {
        $cart = CartItemMother::create();
        $native = $cart->toNative();

        $this->assertIsArray($native);
    }

    public function testCartItemFromNative()
    {
        $cart = CartItemMother::create();
        $native = $cart->toNative();

        $restoredCartItem = CartItem::fromNative($native);

        $this->assertInstanceOf(CartItem::class, $restoredCartItem);
        $this->assertEquals($cart, $restoredCartItem);
    }
}