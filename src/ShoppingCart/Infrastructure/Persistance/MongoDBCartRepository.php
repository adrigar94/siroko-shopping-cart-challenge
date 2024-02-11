<?php

declare(strict_types=1);

namespace Adrian\SirokoShoppingCart\ShoppingCart\Infrastructure\Persistance;

use Adrian\SirokoShoppingCart\Shared\Infrastructure\Persistance\MongoDBConnection;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\Cart;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartRepository;
use Adrian\SirokoShoppingCart\ShoppingCart\Domain\CartStatus;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;

class MongoDBCartRepository implements CartRepository
{
    private const COLLECTION_NAME = 'cart';

    private readonly Database $db;
    private readonly Collection $collection;

    public function __construct(MongoDBConnection $connection)
    {
        $this->db = $connection->getDatabase();
        $this->collection = $this->db->selectCollection(self::COLLECTION_NAME);
        $this->createIndex();
    }

    function findOpenByUserUuid(string $user_uuid): ?Cart
    {
        $document = $this->collection->findOne(
            [
                'user_uuid' => $user_uuid,
                'status' => CartStatus::OPEN,
            ],
            ['typeMap' => ['root' => 'array', 'document' => 'array']]
        );

        return $document ? Cart::fromNative($document) : null;
    }

    function save(Cart $cart): void
    {
        $document = $cart->toNative();

        $this->collection->updateOne(
            [
                'uuid' => $cart->uuid(),
            ],
            [
                '$set' => $document,
            ],
            [
                'upsert' => true,
            ]
        );
    }

    function delete(string $uuid): void
    {
        //TODO
    }

    private function createIndex(): void
    {
        $this->collection->createIndex([
            'uuid' => 1,
        ]);
    }

}