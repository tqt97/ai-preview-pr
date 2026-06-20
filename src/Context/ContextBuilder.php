<?php

declare(strict_types=1);

namespace Review\Context;

use Review\Git\GitDiff;
use Review\Analyzer\CallGraph;

final class ContextBuilder
{
    public function build(GitDiff $diff, CallGraph $graph): Context
    {
        $changedFiles = $diff->files;

        $changedClasses = $this->extractClassesFromFiles($changedFiles);

        $relatedNodes = $this->findRelatedNodes($graph, $changedClasses);

        $risks = $this->detectRisks($changedFiles);

        return new Context(
            changedFiles: $changedFiles,
            changedClasses: $changedClasses,
            relatedNodes: $relatedNodes,
            risks: $risks
        );
    }

    /**
     * Fuel convention:
     * file → class guess
     */
    private function extractClassesFromFiles(array $files): array
    {
        $classes = [];

        foreach ($files as $file) {

            // fuel/app/classes/controller/job/apply.php
            $class = $this->guessClassFromPath($file);

            if ($class !== null) {
                $classes[] = $class;
            }
        }

        return array_values(array_unique($classes));
    }

    private function guessClassFromPath(string $file): ?string
    {
        if (!str_contains($file, 'classes/')) {
            return null;
        }

        $parts = explode('classes/', $file);

        if (!isset($parts[1])) {
            return null;
        }

        $path = $parts[1];

        $path = str_replace('.php', '', $path);

        $segments = explode('/', $path);

        $segments = array_map(
            fn($s) => $this->studly($s),
            $segments
        );

        return implode('_', $segments);
    }

    private function findRelatedNodes(CallGraph $graph, array $classes): array
    {
        $related = [];

        foreach ($graph->getGraph() as $from => $tos) {

            foreach ($classes as $class) {
                if (str_starts_with($from, $class)) {
                    $related = array_merge($related, $tos);
                }
            }
        }

        return array_values(array_unique($related));
    }

    private function detectRisks(array $files): array
    {
        $risks = [];

        foreach ($files as $file) {

            if (str_contains($file, 'model')) {
                $risks[] = 'DATABASE_LAYER_CHANGE';
            }

            if (str_contains($file, 'service')) {
                $risks[] = 'BUSINESS_LOGIC_CHANGE';
            }

            if (str_contains($file, 'controller')) {
                $risks[] = 'API_BEHAVIOR_CHANGE';
            }
        }

        return array_values(array_unique($risks));
    }

    private function studly(string $value): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $value)));
    }
}