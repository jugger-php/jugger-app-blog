<?php

namespace jugger;

class Request
{
	protected $data;
    protected $params;

	public function setParams(array $params)
	{
		$this->params = $params;
	}

	public function setParam(string $name, $value)
	{
		$this->params[$name] = $value;
	}

	public function getParams()
	{
		return $this->params ?? [];
	}

	public function getParam(string $name)
	{
		return $this->getParams()[$name] ?? null;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}
}
