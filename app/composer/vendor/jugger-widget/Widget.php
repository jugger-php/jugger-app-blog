<?php

namespace jugger\widget;

use jugger\Context;

abstract class Widget
{
	protected $params;
	protected $context;
	protected $template;

	public function __construct()
	{
		$this->init();
	}

	protected function init()
	{
		// pass
	}

	public function setContext(Context $context)
	{
		$this->context = $context;
	}

	public function setParam(string $name, $value)
	{
		$this->params[$name] = $value;
	}

	public function setParams(array $params)
	{
		$this->params = $params;
	}

	public function setTemplate(string $filePath)
	{
		$this->template = $filePath;
	}

	protected function runInternal()
	{
		$this->includeTemplate();
	}

	protected function includeTemplate()
	{
		$template = realpath($this->template);
		if (file_exists($template)) {
			include $template;
		}
		else {
			$className = get_class($this);
			throw new \Exception("Не найден шаблон '{$this->template}' для виджета '{$className}'");
		}
	}

	public function render()
	{
		ob_start(null, 0, PHP_OUTPUT_HANDLER_CLEANABLE | PHP_OUTPUT_HANDLER_REMOVABLE);
		try {
			echo $this->runInternal();
			return ob_get_contents();
		}
		finally {
			ob_end_clean();
		}
	}

	public static function renderStatic(Context $context, array $params = [])
	{
		$widget = new static();
		if (isset($params['template'])) {
			$widget->setTemplate($params['template']);
		}
		$widget->setContext($context);
		$widget->setParams($params);
		return $widget->render();
	}
}
