<?php

class Container
{
	protected array $bindings = [];

	public function bind(string $abstract, callable $factory)
	{
		$this->bindings[$abstract] = $factory;
	}

	public function make(string $abstract)
	{
		if (! isset($this->bindings[$abstract])) {
			throw new Exception("No binding for {$abstract}");
		}
		return $this->bindings[$abstract]($this);
	}
}