<?php

class Container
{
	protected array $bindings = [];

	protected array $instances = [];

	public function bind(string $abstract, callable $factory)
	{
		$this->bindings[$abstract] = $factory;
	}

	public function make(string $class)
	{
		// クロージャバインド
		if (isset($this->bindings[$class])) {
			return $this->bindings[$class]($this);
		}

		// Reflectionでコンストラクタの依存を読む
		$reflector = new ReflectionClass($class);

		// 引数なし
		if (! $constructor = $reflector->getConstructor()) {
			return new $class;
		}

		$params = [];
		foreach ($constructor->getParameters() as $param) {
			$paramType = $param->getType();

			// 依存クラスの型を取得して再帰的にmakeする
			if ($paramType && ! $paramType->isBuiltin()) {
				$params[] = $this->make($paramType->getName());
			}
		}

		return $reflector->newInstanceArgs($params);
	}

	public function singleton(string $abstract, callable $factory)
	{
		$this->instances[$abstract] = null;
		$this->bindings[$abstract] = function($c) use ($factory, $abstract) {
			// すでに作ってあればそれを返す
			if ($this->instances[$abstract] !== null) {
				return $this->instances[$abstract];
			}

			// 初回生成
			return $this->instances[$abstract] = $factory($c);
		};
	}
}