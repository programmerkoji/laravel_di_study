<?php

class Logger
{
	protected string $file;

	public function __construct(string $file)
	{
		$this->file = $file;
	}

	public function info(string $message)
	{
		$date = date('Y-m-s H:i:s');
		file_put_contents($this->file, "[$date] INFO: $message\n", FILE_APPEND);
	}
}