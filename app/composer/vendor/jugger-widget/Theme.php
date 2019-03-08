<?php

namespace jugger\widget;

class Theme extends Widget
{
	protected $widget;
	protected $content;

	protected function runInternal()
	{
		$this->widget = $this->params['widget'] ?? null;
		if (!$this->widget) {
			throw new \Exception("Для отрисовки темы, должен быть указан виджет");
		}
		$this->content = $this->widget->render();
		$this->includeTemplate();
	}
}
