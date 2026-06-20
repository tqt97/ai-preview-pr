<?php

declare(strict_types=1);

namespace Review\Context;

final class Context
{
    /**
     * @param string[] $changedFiles
     * @param string[] $changedClasses
     * @param string[] $relatedNodes
     */
    public function __construct(
        public readonly array $changedFiles,
        public readonly array $changedClasses,
        public readonly array $relatedNodes,
        public readonly array $risks
    ) {
    }
}