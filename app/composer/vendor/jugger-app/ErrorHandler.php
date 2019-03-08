<?php

namespace jugger;

interface ErrorHandler
{
	public function process(\Throwable $e);
}
