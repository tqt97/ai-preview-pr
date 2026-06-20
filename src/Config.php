<?php declare(strict_types=1);

namespace Review;

final class Config
{
    private array $config;

    public function __construct(
        private array $data
    ) {}

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function all(): array
    {
        return $this->config;
    }
}
