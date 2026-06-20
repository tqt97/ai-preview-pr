<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Autoloader.php';

$loader = new Review\Autoloader(__DIR__ . '/src');

$loader->register();

$app = (new Review\Bootstrap())->boot();

exit($app->run($argv));