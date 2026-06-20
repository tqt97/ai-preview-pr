<?php declare(strict_types=1);

namespace Review\Console;

final class Console
{
	public function section(string $title): void
	{
		echo PHP_EOL;
		echo '======================================' . PHP_EOL;
		echo ' ' . strtoupper($title) . PHP_EOL;
		echo '======================================' . PHP_EOL;
		echo PHP_EOL;
	}

	public function line(string $message): void
	{
		echo $message . PHP_EOL;
	}

	public function keyValue(string $key, string $value): void
	{
		echo sprintf("%-15s : %s\n", $key, $value);
	}

	public function emptyLine(): void
	{
		echo PHP_EOL;
	}
}
