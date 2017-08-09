<?php

namespace Document\Bridge\FlySystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use MongoDB\Database;

final class FlySystemClientFactory
{
    public static function getLocalClient($root): Filesystem
    {
        return new Filesystem(new Local($root));
    }

    public static function getGridFSClient(Database $database)
    {
        // @TODO implement this
    }
}
