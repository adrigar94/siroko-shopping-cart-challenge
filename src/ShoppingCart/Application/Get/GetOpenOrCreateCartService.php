<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\Get;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Ramsey\Uuid\Uuid;

class GetOpenOrCreateCartService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid): Cart
    {
        $cart = $this->cartRepository->findOpenByUserUuid($userUuid);

        if (!$cart) {
            $cart = Cart::create(Uuid::uuid4()->toString(), $userUuid);
            $this->cartRepository->save($cart);
        }

        return $cart;
    }

}