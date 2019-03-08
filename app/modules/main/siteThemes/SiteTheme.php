<?php

namespace app\modules\main\siteThemes;

use jugger\widget\Page;
use jugger\widget\Theme;

class SiteTheme extends Theme
{
	public function setTemplate(string $template)
	{
		$this->template = realpath(__DIR__."/{$template}/index.php");
		if ($this->template === false || stripos($this->template, __DIR__) !== 0) {
			throw new \Exception("Указанная тема не найдена");
		}
	}

	public function runInternal()
	{
		$widget = $this->params['widget'] ?? null;
		if (($widget instanceof Page) === false) {
			throw new \Exception("Виджет должен быть экземпляром класса ". Page::class);
		}
		parent::runInternal();
	}
}
