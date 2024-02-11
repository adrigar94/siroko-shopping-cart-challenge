<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Application\Get;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\Delete\DeleteCartItemService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartItemMother;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteCartItemServiceTest extends TestCase
{
    private CartRepository|MockObject $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CartRepository::class);
    }

    public function testDeleteItemCart()
    {
        $cart = CartMother::createOpenWithProducts();
        $quantityItems = $cart->totalItems();

        $cartItem = CartItemMother::create(1);
        $cart->upsertItem($cartItem);

        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid')
            ->willReturn($cart);

        $this->repositoryMock->expects($this->once())
            ->method('save')
            ->willReturnCallback(function ($cartSaved) use ($quantityItems) {
                $this->assertEquals($quantityItems, $cartSaved->totalItems());
            });

        $service = new DeleteCartItemService($this->repositoryMock);
        $service->__invoke($cart->userUuid(), $cartItem->productId());
    }
}