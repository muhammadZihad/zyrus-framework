<?php

/**
 * Name: Zyras
 * Description: A mini php framework for fun
 * Version: 0.0.1a
 */


require __DIR__ . '/vendor/autoload.php';

$app = new Zyrus\Application\Application;
$kernel = $app->make(Zyrus\Kernel::class, true);
dd($kernel, $app);
$req = Zyrus\Request\Request::capture();
dd($req);