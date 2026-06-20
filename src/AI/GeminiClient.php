<?php

declare(strict_types=1);

namespace Review\AI;

use RuntimeException;

final class GeminiClient
{
    public function run(string $inputFile, string $outputFile): void
    {
        if (!is_file($inputFile)) {
            throw new RuntimeException("Input file not found: {$inputFile}");
        }

        $command = sprintf(
            'gemini -f %s',
            escapeshellarg($inputFile)
        );

        $result = shell_exec($command);

        if ($result === null) {
            throw new RuntimeException('Gemini CLI execution failed');
        }

        file_put_contents($outputFile, $result);
    }
}