<?php

namespace jugger;

abstract class Action
{
	protected $request;
	protected $context;

	abstract protected function runInternal();

	public function run(Request $request, Context $context): Response
	{
		$this->request = $request;
		$this->context = $context;

		$response = $this->runInternal();
		if ($response instanceof Response) {
			return $response;
		}
		else {
			$obj = $this->context->getDi()->createClass(Response::class);
			$obj->setData($response);
			return $obj;
		}
	}

	final public static function runStatic(Request $request, Context $context): Response
	{
		$action = new static();
		return $action->run($request, $context);
	}
}
