<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\Confirm;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Ramsey\Uuid\Uuid;

class ConfirmCartService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid): void
    {
        $cart = $this->cartRepository->findOpenByUserUuid($userUuid);

        if (!$cart) {
            throw new \Exception('User doesn\'t have open cart', 404);
        }

        $cart->confirm();
        $this->cartRepository->save($cart);
    }

}