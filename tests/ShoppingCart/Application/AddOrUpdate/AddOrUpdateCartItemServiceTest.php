<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Application\AddOrUpdate;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate\AddOrUpdateCartItemDto;
use Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate\AddOrUpdateCartItemService;
use Adrian\SirokoShoppingCart\ShoppingCart\Application\GetCart\GetOpenOrCreateCartService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartItemMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AddOrUpdateCartItemServiceTest extends TestCase
{
    private CartRepository|MockObject $repositoryMock;
    private GetOpenOrCreateCartService|MockObject $getCartServiceMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CartRepository::class);
        $this->getCartServiceMock = $this->createMock(GetOpenOrCreateCartService::class);
    }

    public function testGetNewCart()
    {
        $this->repositoryMock->expects($this->once())
            ->method('save');
        $this->getCartServiceMock->expects($this->once())
            ->method('__invoke');

        $cartItem = CartItemMother::create(1);
        $addOrUpdateCartItemDto = new AddOrUpdateCartItemDto(
            $cartItem->product->sku,
            $cartItem->product->name,
            $cartItem->product->priceInCents,
            $cartItem->product->url,
            $cartItem->product->thumbnail,
            $cartItem->quantity
        );

        $service = new AddOrUpdateCartItemService($this->getCartServiceMock, $this->repositoryMock);
        $service->__invoke(Uuid::uuid4()->__toString(), $addOrUpdateCartItemDto);
    }
}