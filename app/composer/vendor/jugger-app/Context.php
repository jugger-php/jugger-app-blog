<?php

namespace jugger;

final class Context
{
	private $vars = [];

	protected $di;
	protected $session;
	protected $eventManager;

	public function __construct(array $vars = [])
	{
		foreach ($vars as $key => $value) {
			$this->set($key, $value);
		}
	}

	public function set(string $name, $value)
	{
		$this->vars[$name] = $value;
	}

	public function get(string $name)
	{
		return $this->vars[$name] ?? null;
	}

	public function setDi(DependencyContainer $value)
	{
		$this->di = $value;
	}

	public function getDi(): DependencyContainer
	{
		return $this->di;
	}

	public function setSession(Session $value)
	{
		$this->session = $value;
	}

	public function getSession(): Session
	{
		return $this->session;
	}

	public function setEventManager(EventManager $value)
	{
		$this->eventManager = $value;
	}

	public function getEventManager(): EventManager
	{
		return $this->eventManager;
	}
}
