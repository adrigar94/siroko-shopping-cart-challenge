<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Domain;

enum CartStatus: string
{
    case OPEN = 'open';
    case CONFIRMED = 'confirmed';
}