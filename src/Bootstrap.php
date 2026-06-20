<?php

declare(strict_types=1);

namespace Review;

use Review\Application;

final class Bootstrap
{
    public function boot(string $projectRoot): Application
    {
        $config = new Config([
            'project_root' => $projectRoot,
        ]);

        return new Application($config);
    }
}
