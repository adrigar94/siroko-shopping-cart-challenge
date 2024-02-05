<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Ramsey\Uuid\Uuid;

class CartMother
{
    public static function createEmpty(): Cart
    {
        return new Cart(Uuid::uuid4()->__toString());
    }
}