<?php

declare(strict_types=1);

namespace Review\Parser\Model;

final class ParsedFile
{
    /**
     * @param ParsedClass[] $classes
     */
    public function __construct(
        public readonly string $filePath,
        public readonly array $classes
    ) {
    }
}