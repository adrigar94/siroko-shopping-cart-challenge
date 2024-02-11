<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\Get;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;

class GetOpenCartService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid): Cart
    {
        $cart = $this->cartRepository->findOpenByUserUuid($userUuid);

        if (!$cart) {
            throw new \Exception('User doesn\'t have open cart', 404);
        }

        return $cart;
    }

}