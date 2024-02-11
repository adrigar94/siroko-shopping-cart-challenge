<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\Delete;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;

class DeleteCartItemService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid, string $sku): void
    {
        $cart = $this->cartRepository->findOpenByUserUuid($userUuid);

        if (!$cart) {
            throw new \Exception('User doesn\'t have open cart', 404);
        }

        $cart->removeItem($sku);
        $this->cartRepository->save($cart);
    }

}