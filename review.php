<?php declare(strict_types=1);

use Review\Support\Logger;
use Review\Autoloader;
use Review\Bootstrap;

require_once __DIR__ . '/src/Autoloader.php';

$loader = new Autoloader(__DIR__ . '/src');

$loader->register();
$logger = new Logger();
$baseBranch = $argv[1] ?? 'release';
$projectRoot = $argv[2] ?? getcwd();

$logger->info('baseBranch: ' . $baseBranch);
$logger->info('projectRoot: ' . $projectRoot);

$app = (new Bootstrap())->boot($projectRoot);

exit($app->run($baseBranch, $projectRoot));
