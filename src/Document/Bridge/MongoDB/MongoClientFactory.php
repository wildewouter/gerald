<?php

namespace Document\Bridge\MongoDB;

use MongoDB\Client;

final class MongoClientFactory
{
    public static function getClient(): Client
    {
        return new Client();
    }
}
