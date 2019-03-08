<?php

namespace app\modules\pages\actions;

use jugger\Action;
use app\modules\pages\widgets\timer\Timer;

class MainPageView extends Action
{
	public function runInternal()
	{
		$this->request->setParam('code', 'index');
		return PageView::runStatic($this->request, $this->context);
	}
}
