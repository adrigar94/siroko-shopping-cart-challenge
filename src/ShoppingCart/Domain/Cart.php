<?php

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

use DateTimeImmutable;

class Cart
{
    private array $items = [];
    private int $totalItems = 0;

    public function __construct(
        private string $uuid,
        private string $userUuid,
        private CartStatus $status,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt
    ) {
    }

    public static function create(string $uuid, string $userUuid): static
    {
        $now = new DateTimeImmutable();
        return new static(
            $uuid,
            $userUuid,
            CartStatus::OPEN,
            $now,
            $now
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function userUuid(): string
    {
        return $this->userUuid;
    }

    public function status(): CartStatus
    {
        return $this->status;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function updateNow(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function confirm(): void
    {
        $this->status = CartStatus::CONFIRMED;
        $this->updateNow();
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
        $this->updateNow();
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
        $this->updateNow();
    }

    public function removeItem(string $productId): void
    {
        if (!isset($this->items[$productId])) {
            // idempotence. we ignore that it does not exist instead of returning an exception.
            return;
        }
        $this->totalItems -= $this->items[$productId]->quantity;
        unset($this->items[$productId]);
        $this->updateNow();
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