<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Application\Get;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\Get\GetOpenOrCreateCartService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetOpenOrCreateCartServiceTest extends TestCase
{
    private CartRepository|MockObject $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CartRepository::class);
    }

    public function testGetNewCart()
    {
        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid')
            ->willReturn(null);

        $this->repositoryMock->expects($this->once())
            ->method('save');

        $service = new GetOpenOrCreateCartService($this->repositoryMock);
        $result = $service->__invoke(Uuid::uuid4()->__toString());

        $this->assertInstanceOf(Cart::class, $result);
    }

    public function testGetOpenCart()
    {
        $cart = CartMother::createOpenWithProducts();

        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid')
            ->willReturn($cart);

        $this->repositoryMock->expects($this->never())
            ->method('save');

        $service = new GetOpenOrCreateCartService($this->repositoryMock);
        $result = $service->__invoke($cart->userUuid());

        $this->assertEquals($cart, $result);
    }
}