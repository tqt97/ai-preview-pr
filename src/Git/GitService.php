<?php declare(strict_types=1);

namespace Review\Git;

use RuntimeException;

final class GitService
{
	public function __construct(
		private string $projectRoot
	) {}

	public function getCurrentBranch(): string
	{
		$cmd = 'git rev-parse --abbrev-ref HEAD';

		$branch = $this->run($cmd);

		return trim($branch ?: 'unknown');
	}

	public function getDiff(string $baseBranch, string $currentBranch): GitDiff
	{
		$this->ensureGitRepository();

		// echo $cli . PHP_EOL;
		$rawDiff = $this->run("git diff {$baseBranch}...{$currentBranch}");

		$files = $this->extractChangedFiles($rawDiff);

		return new GitDiff(
			baseBranch: $baseBranch,
			currentBranch: $currentBranch,
			files: $files,
			rawDiff: $rawDiff
		);
	}

	private function run(string $command): string
	{
		$cwd = getcwd();

		chdir($this->projectRoot);

		$result = shell_exec($command);

		chdir($cwd);

		return $result ?? '';
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
