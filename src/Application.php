<?php declare(strict_types=1);

namespace Review;

use Review\AI\GeminiClient;
use Review\Analyzer\DependencyAnalyzer;
use Review\Console\Console;
use Review\Context\ContextBuilder;
use Review\Git\GitService;
use Review\Package\PackageBuilder;
use Review\Parser\PhpParser;
use Review\Support\Logger;

final class Application
{
	private Console $console;
	private Logger $logger;

	public function __construct(
		private readonly Config $config
	) {
		$this->console = new Console();
		$this->logger = new Logger();
	}

	public function run(array $argv): int
	{
		$baseBranch = $argv[1] ?? 'release';
		$currentBranch = $this->getCurrentBranch();

		$git = new GitService();
		$diff = $git->getDiff($baseBranch, $currentBranch);

		$this->console->section('AI PR REVIEW CLI');

		$this->logger->success('Git diff loaded');

		$this->console->keyValue('Base Branch', $baseBranch);
		$this->console->keyValue('Current Branch', $currentBranch);

		$this->console->emptyLine();

		$this->logger->info('Changed files:');

		foreach ($diff->files as $file) {
			$this->console->line(' - ' . $file);
		}

		$this->console->emptyLine();

		$this->logger->success('Git layer ready');

		$parser = new PhpParser();

		$parsedFiles = [];

		foreach ($diff->files as $file) {
			$parsedFiles[] = $parser->parseFile($file);
		}

		$analyzer = new DependencyAnalyzer();
		$graph = $analyzer->buildCallGraph($parsedFiles);

		$this->console->section('CALL GRAPH');

		$graph->print();

		$this->logger->success('Dependency graph built');

		$contextBuilder = new ContextBuilder();

		$context = $contextBuilder->build($diff, $graph);

		$this->console->section('CONTEXT ANALYSIS');

		$this->logger->info('Changed Files:');

		foreach ($context->changedFiles as $file) {
			$this->console->line(' - ' . $file);
		}

		$this->logger->info('Changed Classes:');

		foreach ($context->changedClasses as $class) {
			$this->console->line(' - ' . $class);
		}

		$this->logger->info('Related Nodes:');

		foreach ($context->relatedNodes as $node) {
			$this->console->line(' - ' . $node);
		}

		$this->logger->warning('Detected Risks:');

		foreach ($context->risks as $risk) {
			$this->console->line(' - ' . $risk);
		}

		$this->logger->success('Context built successfully');

		$packageBuilder = new PackageBuilder();

		$package = $packageBuilder->build($diff, $context);

		$file = getcwd() . '/review/package.md';

		file_put_contents($file, $package->content);

		$this->logger->success('Package generated: review/package.md');

		// $gemini = new GeminiClient();

		// $inputFile = getcwd() . '/review/package.md';
		// $outputFile = getcwd() . '/review/result.md';

		// $this->logger->info('Running Gemini AI Review...');

		// $gemini->run($inputFile, $outputFile);

		// $this->logger->success('AI Review completed');
		// $this->logger->info('Output: review/result.md');

		// $this->console->section('DONE');

		// $this->console->line('Review generated successfully.');
		// $this->console->line('Check: review/result.md');

		return 0;
	}

	private function getCurrentBranch(): string
	{
		$branch = shell_exec('git rev-parse --abbrev-ref HEAD');

		if ($branch === null) {
			return 'unknown';
		}

		return trim($branch);
	}
}
