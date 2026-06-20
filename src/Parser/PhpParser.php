<?php

declare(strict_types=1);

namespace Review\Parser;

use Review\Parser\Model\ParsedClass;
use Review\Parser\Model\ParsedFile;
use Review\Parser\Model\ParsedMethod;

final class PhpParser
{
    public function parseFile(string $filePath): ParsedFile
    {
        if (!is_file($filePath)) {
            return new ParsedFile($filePath, []);
        }

        $code = file_get_contents($filePath);

        if ($code === false) {
            return new ParsedFile($filePath, []);
        }

        $tokens = token_get_all($code);

        $namespace = null;
        $className = null;
        $methods = [];
        $currentMethod = null;
        $currentCalls = [];

        foreach ($tokens as $index => $token) {

            // Namespace
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                $namespace = $this->collectNamespace($tokens, $index);
            }

            // Class
            if (is_array($token) && $token[0] === T_CLASS) {
                $className = $this->collectClassName($tokens, $index);
            }

            // Function (method)
            if (is_array($token) && $token[0] === T_FUNCTION) {
                $methodName = $this->collectFunctionName($tokens, $index);

                if ($methodName !== null) {
                    $methods[] = new ParsedMethod(
                        name: $methodName,
                        calls: []
                    );
                }
            }
        }

        if ($className === null) {
            return new ParsedFile($filePath, []);
        }

        return new ParsedFile(
            filePath: $filePath,
            classes: [
                new ParsedClass(
                    name: $className,
                    methods: array_map(fn($m) => $m->name, $methods),
                    namespace: $namespace
                )
            ]
        );
    }

    private function collectNamespace(array $tokens, int $index): ?string
    {
        $ns = '';

        for ($i = $index + 1; $i < count($tokens); $i++) {
            if (!is_array($tokens[$i])) {
                break;
            }

            if (in_array($tokens[$i][0], [T_STRING, T_NAME_QUALIFIED])) {
                $ns .= $tokens[$i][1] . '\\';
            }
        }

        return rtrim($ns, '\\');
    }

    private function collectClassName(array $tokens, int $index): ?string
    {
        for ($i = $index + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                return $tokens[$i][1];
            }
        }

        return null;
    }

    private function collectFunctionName(array $tokens, int $index): ?string
    {
        for ($i = $index + 1; $i < count($tokens); $i++) {
            if (is_array($tokens[$i]) && $tokens[$i][0] === T_STRING) {
                return $tokens[$i][1];
            }
        }

        return null;
    }
}