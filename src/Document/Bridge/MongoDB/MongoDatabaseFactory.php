<?php

namespace Document\Bridge\MongoDB;

use MongoDB\Client;
use MongoDB\Database;

final class MongoDatabaseFactory
{
    public static function getClient($database): Database
    {
        return (new Client())->selectDatabase($database);
    }
}
