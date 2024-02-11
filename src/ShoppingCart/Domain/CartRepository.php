<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

interface CartRepository
{
    public function findOpenByUserUuid(string $uuid): ?Cart;

    public function save(Cart $cart): void;

    public function delete(string $uuid): void;
}