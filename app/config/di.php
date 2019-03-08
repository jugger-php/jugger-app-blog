<?php

$di = new \jugger\DependencyContainer();
$di->setClass('\jugger\Request', '\jugger\Request');
$di->setClass('\jugger\Response', '\jugger\implement\RawResponse');

$di->setSingleton('\jugger\UrlRewriter', '\jugger\implement\DefaultUrlRewriter');
$di->setSingleton('\jugger\EventManager', '\jugger\EventManager');
$di->setSingleton('\jugger\asset\AssetManager', function() {
	$path = __DIR__.'/../../assets';
	$obj = new \jugger\asset\implement\DefaultAssetManager($path);
	return $obj;
});

return $di;
