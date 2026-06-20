<?php

declare(strict_types=1);

namespace Review;

use Review\Application;

final class Bootstrap
{
    public function boot(): Application
    {
        $config = new Config(
            dirname(__DIR__) . '/config/config.php'
        );

        return new Application($config);
    }
}