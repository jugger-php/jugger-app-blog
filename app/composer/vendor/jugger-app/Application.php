<?php

namespace jugger;

final class Application
{
	const EVENT_BEFORE_CONTEXT = __CLASS__.':eventBeforeConext';
	const EVENT_BEFORE_ROUTER = __CLASS__.':eventBeforeRouter';
	const EVENT_BEFORE_ACTION = __CLASS__.':eventBeforeAction';
	const EVENT_BEFORE_SEND_RESPONSE = __CLASS__.':eventBeforeSendResponse';
	const EVENT_BEFORE_END = __CLASS__.':eventBeforeExit';

	protected $di;
	protected $params;
	protected $rootDir;
	protected $eventManager;

	public function __construct(DependencyContainer $di)
	{
		$this->setDi($di);
	}

	public function setDi(DependencyContainer $di)
	{
		$this->di = $di;
	}

	public function setParams(array $params)
	{
		$this->params = $params;
	}

	public function setRootDir(string $dir)
	{
		$this->rootDir = $dir;
	}

	public function setEventManager(EventManager $value)
	{
		$this->eventManager = $value;
	}

	public function run(string $route, array $params, $data = null)
	{
		$di = $this->getDi();

		$request = $di->createClass(Request::class);
		$request->setParams($params);
		$request->setData($data);

		return $this->runByRequest($route, $request);
	}

	public function runByRequest(?string $route, Request $request)
	{
		try {
			if (!$route) {
				throw new NotFoundException;
			}

			$this->eventManager->trigger(self::EVENT_BEFORE_CONTEXT, [$route, $request]);
			$context = $this->createContext($request);

			$this->eventManager->trigger(self::EVENT_BEFORE_ROUTER, [$request, $context]);
			$actionClass = $this->getActionClass($route);

			$this->eventManager->trigger(self::EVENT_BEFORE_ACTION, [$request, $context]);
			$action = new $actionClass;
			$response = $action->run($request, $context);

			$this->eventManager->trigger(self::EVENT_BEFORE_SEND_RESPONSE, [$request, $context, $response]);
			$response->send();

			$this->eventManager->trigger(self::EVENT_BEFORE_END, [$context, $response]);
			return;
		}
		catch (\Throwable $e) {
			$errorHanlder = $this->di->createClass(ErrorHandler::class);
			if ($errorHanlder) {
				$errorHanlder->process($e);
			}
			else {
				throw $e;
			}
		}
	}

	protected function createContext(Request $request)
	{
		$context = new Context($this->params ?: []);
		$context->setDi($this->di);
		$context->setEventManager($this->eventManager);
		return $context;
	}

	protected function getActionClass(string $route)
	{
		$router = new Router($this->rootDir);
		$actionClass = $router->getActionClass($route);
		if ($actionClass) {
			$reflectionClass = new \ReflectionClass($actionClass);
			if (!$reflectionClass->isSubclassOf(Action::class)) {
				throw new \Exception("Действие должно реализовывать класс ". Action::class);
			}
		}
		else {
			throw new \Exception("Не удалось найти экшон по маршруту '{$route}'");
		}
		return $actionClass;
	}

	public function check()
	{
		$this->di->checkDependencies([
			Response::class,
			Request::class,
		]);
	}
}
