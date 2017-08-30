<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

require __DIR__.'/../vendor/autoload.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$isDebug = getenv('DEBUG');

if ($isDebug) {
    Debug::enable();
}

$kernel = new AppKernel(getenv('ENV'), $isDebug);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
