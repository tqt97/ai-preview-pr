<?php

declare(strict_types=1);

namespace Review\Parser\Model;

final class Call
{
    public function __construct(
        public readonly string $type,   // static | object | new
        public readonly string $target  // class/method name
    ) {
    }
}