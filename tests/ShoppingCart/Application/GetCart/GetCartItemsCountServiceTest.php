<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Application\Get;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\Get\GetCartItemsCountService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain\CartMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCartItemsCountServiceTest extends TestCase
{
    private CartRepository|MockObject $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CartRepository::class);
    }

    public function testGetCartItemsCount()
    {
        $cart = CartMother::createOpenWithProducts();

        $this->repositoryMock->expects($this->once())
            ->method('findOpenByUserUuid')
            ->willReturn($cart);

        $service = new GetCartItemsCountService($this->repositoryMock);
        $result = $service->__invoke($cart->userUuid());

        $this->assertEquals($cart->totalItems(), $result);
    }
}