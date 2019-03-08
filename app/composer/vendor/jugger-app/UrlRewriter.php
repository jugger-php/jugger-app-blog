<?php

namespace jugger;

abstract class UrlRewriter
{
	protected $rules;
	protected $request;

	public function setRules(array $rules)
	{
		foreach ($rules as $key => $value) {
			$this->addRule($key, $value);
		}
	}

	public function addRule(string $template, string $route)
	{
		$this->rules[$template] = $route;
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

	public function getRequest(): Request
	{
		return $this->request;
	}

	abstract public function getRoute(string $url): ?string;
}
