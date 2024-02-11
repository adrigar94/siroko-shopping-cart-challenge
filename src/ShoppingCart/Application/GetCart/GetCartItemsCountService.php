<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\GetCart;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;

class GetCartItemsCountService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid): int
    {
        $cart = $this->cartRepository->findOpenByUserUuid($userUuid);

        if (!$cart) {
            throw new \Exception('User doesn\'t have open cart', 404);
        }

        return $cart->totalItems();
    }

}