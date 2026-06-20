<?php

declare(strict_types=1);

namespace Review\Context;


final class Context
{
    /**
     * @param string[] $changedClasses
     * @param string[] $relatedNodes
     * @param string[] $risks
     */
    public function __construct(
        public readonly array $changedClasses,
        public readonly array $relatedNodes,
        public readonly array $risks,
    ) {
    }
}