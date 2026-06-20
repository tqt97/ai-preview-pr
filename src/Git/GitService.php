<?php declare(strict_types=1);

namespace Review\Git;

use RuntimeException;

final class GitService
{
	public function getDiff(string $baseBranch, string $currentBranch): GitDiff
	{
		$this->ensureGitRepository();

		$diffCommand = sprintf(
			'git diff %s...%s',
			escapeshellarg($baseBranch),
			escapeshellarg($currentBranch)
		);

		$rawDiff = shell_exec($diffCommand);

		if ($rawDiff === null) {
			throw new RuntimeException('Failed to execute git diff');
		}

		$files = $this->extractChangedFiles($rawDiff);

		return new GitDiff(
			baseBranch: $baseBranch,
			currentBranch: $currentBranch,
			files: $files,
			rawDiff: $rawDiff
		);
	}

	/**
	 * Extract changed files from git diff
	 */
	private function extractChangedFiles(string $diff): array
	{
		$files = [];

		$lines = explode("\n", $diff);

		foreach ($lines as $line) {
			// Git diff format:
			// diff --git a/file.php b/file.php

			if (str_starts_with($line, 'diff --git')) {
				preg_match('/b\/(.+)$/', $line, $matches);

				if (isset($matches[1])) {
					$files[] = $this->normalizePath($matches[1]);
				}
			}
		}

		return array_values(array_unique($files));
	}

	/**
	 * FuelPHP normalization:
	 * convert file path → class-like structure later
	 */
	private function normalizePath(string $path): string
	{
		return ltrim($path, '/');
	}

	private function ensureGitRepository(): void
	{
		exec('git rev-parse --is-inside-work-tree 2>/dev/null', $output, $code);

		if ($code !== 0) {
			throw new RuntimeException('Not a git repository');
		}
	}
}
