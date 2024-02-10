<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Application\AddOrUpdate;

use Adrian\SirokoShoppingCart\ShoppingCart\Application\GetCart\GetOpenOrCreateCartService;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartItem;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Product;

class AddOrUpdateCartItemService
{
    public function __construct(private GetOpenOrCreateCartService $getOpenOrCreatCart, private CartRepository $cartRepository)
    {
    }

    public function __invoke(string $userUuid, AddOrUpdateCartItemDto $cartItemDto): void
    {
        $cart = $this->getOpenOrCreatCart->__invoke($userUuid);

        $product = new Product($cartItemDto->sku, $cartItemDto->name, $cartItemDto->priceInCents, $cartItemDto->url, $cartItemDto->thumbnail);
        $cartItem = new CartItem($product, $cartItemDto->quantity);
        $cart->upsertItem($cartItem);

        $this->cartRepository->save($cart);
    }
}
