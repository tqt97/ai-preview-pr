<?php

declare(strict_types=1);

namespace Review\Parser\Model;

final class ParsedMethod
{
    /**
     * @param string[] $calls
     */
    public function __construct(
        public readonly string $name,
        public readonly array $calls = []
    ) {
    }
}