<?php

declare(strict_types=1);

namespace Review\Analyzer;

final class CallGraph
{
    /**
     * @var array<string, string[]>
     */
    private array $graph = [];

    public function addEdge(string $from, string $to): void
    {
        if (!isset($this->graph[$from])) {
            $this->graph[$from] = [];
        }

        $this->graph[$from][] = $to;
    }

    public function getGraph(): array
    {
        return $this->graph;
    }

    public function print(): void
    {
        foreach ($this->graph as $from => $tos) {
            echo $from . PHP_EOL;

            foreach ($tos as $to) {
                echo "  → " . $to . PHP_EOL;
            }
        }
    }
}