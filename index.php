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

$req = Zyrus\Request\Request::capture();

// dd($kernel, $app, $req->all());