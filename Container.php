<?php

class Container
{
	protected array $bindings = [];

	protected array $instances = [];

	public function bind(string $abstract, string|callable $concrete)
	{
		$this->bindings[$abstract] = $concrete;
	}

	public function make(string $abstract)
	{
		// ---- ★ ① バインドに callable が入っている場合（Closure） ----
		if (isset($this->bindings[$abstract]) && is_callable($this->bindings[$abstract])) {
			return $this->bindings[$abstract]($this);
		}

		// ---- ★ ② バインドに class-string が入っている場合 → 実装クラスに差し替え ----
		if (isset($this->bindings[$abstract]) && is_string($this->bindings[$abstract])) {
            $abstract = $this->bindings[$abstract];
        }

		// ---- ★ ③ auto-wiring（Reflection） ----
		$reflector = new ReflectionClass($abstract);

		if (!$reflector->isInstantiable()) {
            throw new Exception("Cannot instantiate {$abstract}");
        }

		// 引数なし
		if (! $constructor = $reflector->getConstructor()) {
			return new $abstract;
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
			if ($c->instances[$abstract] !== null) {
				return $c->instances[$abstract];
			}

			// 初回生成
			return $c->instances[$abstract] = $factory($c);
		};
	}
}