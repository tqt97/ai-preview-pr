<?php

declare(strict_types=1);

namespace Review\Analyzer;

use Review\Parser\Model\ParsedFile;
use Review\Parser\Model\ParsedClass;
use Review\Parser\Model\ParsedMethod;
use Review\Parser\Model\Call;

final class DependencyAnalyzer
{
    public function buildCallGraph(array $parsedFiles): CallGraph
    {
        $graph = new CallGraph();

        foreach ($parsedFiles as $file) {
            /** @var ParsedFile $file */

            foreach ($file->classes as $class) {

                $className = $class->name;

                foreach ($class->methods as $method) {

                    $from = $className . '::' . $method;

                    // fake parsing stage (Part 4 simplified)
                    // real call detection will be Part 5 (deep AST)

                    $calls = $this->extractMockCalls($method);

                    foreach ($calls as $call) {
                        $graph->addEdge($from, $call->target);
                    }
                }
            }
        }

        return $graph;
    }

    /**
     * TEMP: simplified heuristic (Part 5 will replace this)
     */
    private function extractMockCalls(string $methodName): array
    {
        $calls = [];

        if (str_contains($methodName, 'apply')) {
            $calls[] = new Call('static', 'Service_Apply::execute');
        }

        if (str_contains($methodName, 'index')) {
            $calls[] = new Call('object', 'Repository_User::find');
        }

        return $calls;
    }
}