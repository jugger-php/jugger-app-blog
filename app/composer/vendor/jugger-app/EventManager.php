<?php

namespace jugger;

class EventManager
{
	protected $handlers = [];

	public function on(string $eventName, callable $handler)
	{
		$this->handlers[$eventName] = $this->handlers[$eventName] ?? [];
		$this->handlers[$eventName][] = $handler;
	}

	public function off(string $eventName, callable $handler)
	{
		$handlers = $this->handlers[$eventName] ?? [];
		$this->handlers[$eventName] = array_filter($handlers, function($setHandler) use($handler) {
			return $setHandler !== $handler;
		});
	}

	public function trigger(string $eventName, array $params = [])
	{
		$handlers = $this->handlers[$eventName] ?? [];
		foreach ($handlers as $handler) {
			$params = $this->triggerHandler($handler, $params);
		}
		return $params;
	}

	protected function triggerHandler(callable $handler, array $params)
	{
		$ret = call_user_func($handler, $params);
		if (is_array($ret)) {
			return $ret;
		}
		return $params;
	}
}
