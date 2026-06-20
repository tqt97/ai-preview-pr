<?php declare(strict_types=1);

namespace Review;

final class Autoloader
{
	public function __construct(
		private readonly string $basePath
	) {}

	public function register(): void
	{
		spl_autoload_register([$this, 'loadClass']);
	}

	public function loadClass(string $class): void
	{
		// Only handle our namespace
		if (!str_starts_with($class, 'Review\\')) {
			return;
		}

		// Remove root namespace
		$relativeClass = substr($class, strlen('Review\\'));

		// Convert namespace to path
		$relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass);

		$file = $this->basePath . DIRECTORY_SEPARATOR . $relativePath . '.php';

		if (is_file($file)) {
			require_once $file;
		}
	}
}
