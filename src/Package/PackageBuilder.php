<?php declare(strict_types=1);

namespace Review\Package;

use Review\Context\Context;
use Review\Git\GitDiff;

final class PackageBuilder
{
	public function build(GitDiff $diff, Context $context): Package
	{
		$content = $this->buildHeader($diff)
			. $this->buildDiffSection($diff)
			. $this->buildContextSection($context)
			. $this->buildRiskSection($context)
			. $this->buildRulesSection();

		return new Package($content);
	}

	private function buildHeader(GitDiff $diff): string
	{
		return <<<MD
			# AI PR REVIEW PACKAGE

			## Branch Info
			- Base: {$diff->baseBranch}
			- Current: {$diff->currentBranch}

			---

			MD;
	}

	private function buildDiffSection(GitDiff $diff): string
	{
		$files = implode("\n- ", $diff->files);

		return <<<MD
			## Changed Files

			- {$files}

			---

			MD;
	}

	private function buildContextSection(Context $context): string
	{
		$files = implode("\n- ", $context->changedFiles);
		$classes = implode("\n- ", $context->changedClasses);
		$related = implode("\n- ", $context->relatedNodes);

		return <<<MD
			## Context Analysis

			### Changed Files
			- {$files}

			### Changed Classes
			- {$classes}

			### Related Impact Nodes
			- {$related}

			---

			MD;
	}

	private function buildRiskSection(Context $context): string
	{
		$risks = implode("\n- ", $context->risks);

		return <<<MD
			## Risk Analysis

			- {$risks}

			---

			MD;
	}

	private function buildRulesSection(): string
	{
		return <<<MD
			## Review Rules

			- Ensure Controller → Service → Repository → Model flow
			- Check SQL performance & N+1 issues
			- Validate FuelPHP naming convention (_ based structure)
			- Detect duplicate logic
			- Ensure no business logic in Controller
			- Validate regression risk
			- Check missing validation / security issues

			---

			MD;
	}
}
