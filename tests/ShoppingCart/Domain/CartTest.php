<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartItem;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartStatus;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCreateCart()
    {
        $cart = CartMother::createEmpty();
        $this->assertInstanceOf(Cart::class, $cart);
    }

    public function testCartParamsCorrectTpye()
    {
        $cart = CartMother::createEmpty();
        $this->assertIsString($cart->uuid());
        $this->assertIsString($cart->userUuid());
        $this->assertInstanceOf(CartStatus::class, $cart->status());
        $this->assertInstanceOf(\DateTimeImmutable::class, $cart->createdAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $cart->updatedAt());
    }

    public function testConfirmCart()
    {
        $cart = CartMother::createEmpty();
        $this->assertEquals(CartStatus::OPEN, $cart->status());
        $cart->confirm();
        $this->assertEquals(CartStatus::CONFIRMED, $cart->status());
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

    public function testUpdateItem()
    {
        $product = ProductMother::random();
        $cart = CartMother::createEmpty();

        $cart->addItem(new CartItem($product, 1));
        $this->assertEquals(1, $cart->totalItems());

        $cart->updateItem(new CartItem($product, 3));
        $this->assertEquals(3, $cart->totalItems());
    }

    public function testUpdateNonexistentItem()
    {
        $product = ProductMother::random();
        $cart = CartMother::createEmpty();

        $cart->addItem(new CartItem($product, 1));
        $this->assertEquals(1, $cart->totalItems());


        $otherProduct = ProductMother::random();

        $this->expectExceptionCode(404);
        $cart->updateItem(new CartItem($otherProduct, 3));

    }

    public function testRemoveItem()
    {
        $cart = CartMother::createEmpty();

        $product = ProductMother::random();
        $cartItem = new CartItem($product, 2);

        $cart->addItem($cartItem);
        $cart->addItem(CartItemMother::create());
        $this->assertEquals(3, $cart->totalItems());

        $cart->removeItem($cartItem->productId());
        $this->assertEquals(1, $cart->totalItems());
    }

    public function testRemoveIdemItem()
    {
        $cart = CartMother::createEmpty();

        $product = ProductMother::random();
        $cartItem = new CartItem($product, 2);

        $cart->addItem($cartItem);
        $cart->addItem(CartItemMother::create());
        $this->assertEquals(3, $cart->totalItems());

        $cart->removeItem($cartItem->productId());
        $this->assertEquals(1, $cart->totalItems());

        $cart->removeItem($cartItem->productId());
        $this->assertEquals(1, $cart->totalItems());
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

    public function testUpdatedAt()
    {
        $cart = CartMother::createEmpty();
        $cartItem = CartItemMother::create();

        $originalUpdateAt = $cart->updatedAt();
        $cart->addItem($cartItem);
        $this->assertGreaterThan($originalUpdateAt, $cart->updatedAt());

        $originalUpdateAt = $cart->updatedAt();
        $cart->updateItem($cartItem);
        $this->assertGreaterThan($originalUpdateAt, $cart->updatedAt());

        $originalUpdateAt = $cart->updatedAt();
        $cart->removeItem($cartItem->productId());
        $this->assertGreaterThan($originalUpdateAt, $cart->updatedAt());

        $originalUpdateAt = $cart->updatedAt();
        $cart->confirm();
        $this->assertGreaterThan($originalUpdateAt, $cart->updatedAt());
    }

}