<?php

namespace jugger;

class Response
{
	protected $data;

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}

	public function send()
	{
		$class = get_class($this);
		throw new \Exception("Класс '{$class}' не отправляет данные");
	}
}
