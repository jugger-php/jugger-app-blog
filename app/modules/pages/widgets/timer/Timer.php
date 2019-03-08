<?php

namespace app\modules\pages\widgets\timer;

use jugger\widget\Widget;

class Timer extends Widget
{
	protected function init()
	{
		$this->setTemplate(__DIR__.'/templates/pure.php');
	}
}
