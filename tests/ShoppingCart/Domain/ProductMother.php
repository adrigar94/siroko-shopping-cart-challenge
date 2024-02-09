<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\Tests\ShoppingCart\Domain;

use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Product;

class ProductMother
{
    public static function random(): Product
    {
        $faker = \Faker\Factory::create();
        return new Product(
            $faker->ean8(),
            $faker->title(),
            $faker->randomNumber(),
            $faker->url(),
            $faker->url(),
        );
    }
}