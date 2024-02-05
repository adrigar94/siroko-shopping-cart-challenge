<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartItem;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCreateCart()
    {
        $cart = CartMother::createEmpty();
        $this->assertInstanceOf(Cart::class, $cart);
    }

    public function testAddItem()
    {
        $cart = CartMother::createEmpty();

        $cart->addItem(CartItemMother::create());
        $this->assertEquals(1, $cart->totalItems());

        $cart->addItem(CartItemMother::create(2));
        $this->assertEquals(3, $cart->totalItems());
    }

    public function testAddEqualItem()
    {
        $product = ProductMother::random();
        $cart = CartMother::createEmpty();

        $cart->addItem(new CartItem($product, 1));
        $this->assertEquals(1, $cart->totalItems());

        $cart->addItem(new CartItem($product, 2));
        $this->assertEquals(2, $cart->totalItems());
    }

    public function testRemoveItem()
    {
        $product = ProductMother::random();
        $cart = CartMother::createEmpty();

        $cart->addItem(new CartItem($product, 2));
        $cart->addItem(CartItemMother::create());
        $this->assertEquals(3, $cart->totalItems());

        $cart->removeItem($product->uuid);
        $this->assertEquals(1, $cart->totalItems());
    }

    public function testUpdateItem()
    {
        $product = ProductMother::random();
        $cart = CartMother::createEmpty();

        $cart->addItem(new CartItem($product, 1));
        $this->assertEquals(1, $cart->totalItems());

        $cart->updateItem(new CartItem($product, 3));
        $this->assertEquals(3, $cart->totalItems());
    }

    public function testGetTotalItems()
    {
        $cart = CartMother::createEmpty();

        $cart->addItem(CartItemMother::create(3));
        $cart->addItem(CartItemMother::create());
        $cart->addItem(CartItemMother::create());
        $this->assertEquals(5, $cart->totalItems());
    }

    public function testGetItems()
    {
        $cart = CartMother::createEmpty();

        $cart->addItem(CartItemMother::create());
        $cart->addItem(CartItemMother::create(2));

        $count = 0;
        foreach ($cart->items() as $item) {
            $this->assertInstanceOf(CartItem::class, $item);
            $count += $item->quantity;
        }
        $this->assertEquals(3, $count);
    }

}