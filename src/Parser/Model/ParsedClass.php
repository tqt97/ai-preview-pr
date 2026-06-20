<?php

declare(strict_types=1);

namespace Review\Parser\Model;

final class ParsedClass
{
    /**
     * @param string[] $methods
     */
    public function __construct(
        public readonly string $name,
        public readonly array $methods = [],
        public readonly ?string $namespace = null
    ) {
    }
}