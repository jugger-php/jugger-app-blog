<?php

$eventManager = $di->createClass('jugger\EventManager');

$startTime = null;
$eventManager->on(\jugger\Application::EVENT_BEFORE_CONTEXT, function(array $params) use(&$startTime) {
	$startTime = microtime(true);
});
$eventManager->on(\jugger\Application::EVENT_BEFORE_END, function(array $params) use(&$startTime) {
	$timeExecute = microtime(true) - $startTime;
	$maxMemoryExecute = memory_get_peak_usage(true) / 1024;
	echo join("<br>", [
		"",
		"time execute: {$timeExecute} sec",
		"memory (max): {$maxMemoryExecute} Kb",
	]);
});

return $eventManager;
