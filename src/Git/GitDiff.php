<?php declare(strict_types=1);

namespace Review\Git;

final class GitDiff
{
	/**
	 * @param string[] $files
	 */
	public function __construct(
		public readonly string $baseBranch,
		public readonly string $currentBranch,
		public readonly array $files,
		public readonly string $rawDiff
	) {}
}
