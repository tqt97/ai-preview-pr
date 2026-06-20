<?php

declare(strict_types=1);

namespace Review;

final class Config
{
    private array $config;

    public function __construct(string $configFile)
    {
        if (! file_exists($configFile)) {
            throw new \RuntimeException(
                sprintf('Config file not found: %s', $configFile)
            );
        }

        $this->config = require $configFile;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->config;
    }
}