<?php

declare(strict_types=1);

namespace Review\Package;

final class Package
{
    public function __construct(
        public readonly string $content
    ) {
    }
}