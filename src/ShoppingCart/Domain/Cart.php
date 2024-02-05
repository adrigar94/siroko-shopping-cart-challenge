<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

class Cart
{
    private array $items = [];
    private int $totalItems = 0;

    public function __construct(private string $uuid)
    {
    }

    public function id(): string
    {
        return $this->uuid;
    }

    public function addItem(CartItem $cartItem): void
    {
        if (isset($this->items[$cartItem->productId()])) {
            // Cuando el producto ya esta en una linea del carrito y volvemos a añadirlo tenemos 2 posibilidades:
            // 1. Sumar la cantidad del producto al carrito, como si quisieramos añadir más.
            // 2. La idempotencia. Actualizar la cantidad del producto en el carrito ignorando que ya existía.  
            // En este caso opto por la opción 2.
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