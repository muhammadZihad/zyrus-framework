<?php

/**
 * Name: Zyras
 * Description: A mini php framework for fun
 * Version: 0.0.1a
 */
define('ZYRUS_START', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$path = __DIR__;

$app = new Zyrus\Application\Application($path);

$kernel = $app->make(Zyrus\Kernel::class, true);

$response = $kernel->handle(Zyrus\Request\Request::capture());

echo $response;