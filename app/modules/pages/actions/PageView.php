<?php

namespace app\modules\pages\actions;

use jugger\Action;
use jugger\widget\Page;
use app\modules\main\siteThemes\SiteTheme;

class PageView extends Action
{
	public function runInternal()
	{
		$code = $this->request->getParam('code');

		$pagesDirPath = realpath(__DIR__.'/pages');
		$pagePath = realpath("{$pagesDirPath}/{$code}.php");

		if ($pagePath === false || stripos($pagePath, $pagesDirPath) !== 0) {
			throw new \jugger\NotFoundException();
		}

		$page = new Page();
		$page->setContext($this->context);
		$page->setTemplate($pagePath);

		$theme = new SiteTheme();
		$theme->setParam('widget', $page);
		$theme->setContext($this->context);
		$theme->setTemplate('main');

		return $theme->render();
	}
}
