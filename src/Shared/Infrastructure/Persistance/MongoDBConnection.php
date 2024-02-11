<?php

namespace Adrian\SirokoShoppingCart\Shared\Infrastructure\Persistance;

use MongoDB\Client;

class MongoDBConnection
{
    private readonly Client $client;

    public function __construct(
        string $uri,
        private readonly string $databaseName
    ) {
        $this->client = new Client($uri);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDatabase(): \MongoDB\Database
    {
        return $this->client->selectDatabase($this->databaseName);
    }
}