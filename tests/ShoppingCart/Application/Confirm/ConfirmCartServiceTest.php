<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Application\Confirm;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\Confirm\ConfirmCartService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfirmCartServiceTest extends TestCase
{
    private CartRepository|MockObject $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CartRepository::class);
    }

    public function testConfirmCart()
    {
        $cart = CartMother::createOpenWithProducts();

        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid')
            ->willReturn($cart);

        $this->repositoryMock->expects($this->once())
            ->method('save');

        $service = new ConfirmCartService($this->repositoryMock);
        $service->__invoke($cart->userUuid());
    }

    public function testConfirmNotFoundCart()
    {
        $cart = CartMother::createOpenWithProducts();

        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid');

        $this->repositoryMock->expects($this->never())
            ->method('save');

        $this->expectExceptionCode(404);

        $service = new ConfirmCartService($this->repositoryMock);
        $service->__invoke($cart->userUuid());
    }
}