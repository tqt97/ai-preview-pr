<?php declare(strict_types=1);

namespace Review\Support;

final class Logger
{
	public function info(string $message): void
	{
		$this->write('INFO', $message, "\e[36m");
	}

	public function success(string $message): void
	{
		$this->write('SUCCESS', $message, "\e[32m");
	}

	public function warning(string $message): void
	{
		$this->write('WARN', $message, "\e[33m");
	}

	public function error(string $message): void
	{
		$this->write('ERROR', $message, "\e[31m");
	}

	private function write(string $level, string $message, string $color): void
	{
		$reset = "\e[0m";

		echo sprintf(
			"%s[%s]%s %s%s\n",
			$color,
			$level,
			$reset,
			$message,
			$reset
		);
	}
}
