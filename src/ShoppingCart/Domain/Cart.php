<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

class Cart
{
    private array $items = [];
    private int $totalItems = 0;

    public function __construct(private string $uuid)
    {
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function addItem(CartItem $cartItem): void
    {
        if (isset($this->items[$cartItem->productId()])) {
            // When the product is already on a cart line and we add it again, we have two options:
            // 1. Add the quantity of the product to the cart, as if we wanted to add more.
            // 2. Idempotence. Update the quantity of the product in the cart, ignoring that it already existed.
            // In this case, I opt for option 2.
            $this->updateItem($cartItem);
            return;
        }

        $this->items[$cartItem->productId()] = $cartItem;
        $this->totalItems += $cartItem->quantity;
    }

    public function updateItem(CartItem $cartItem): void
    {
        $productId = $cartItem->productId();

        if (!isset($this->items[$productId])) {
            throw new \Exception("Item with product ID $productId does not exist in the cart", 404);
        }

        $this->totalItems -= $this->items[$productId]->quantity;
        $this->items[$productId] = $cartItem;
        $this->totalItems += $cartItem->quantity;
    }

    public function removeItem(string $productId): void
    {
        if (!isset($this->items[$productId])) {
            // idempotence. we ignore that it does not exist instead of returning an exception.
            return;
        }
        $this->totalItems -= $this->items[$productId]->quantity;
        unset($this->items[$productId]);
    }

    /** @return CartItem[] */
    public function items(): array
    {
        return $this->items;
    }

    public function totalItems(): int
    {
        return $this->totalItems;
    }
}