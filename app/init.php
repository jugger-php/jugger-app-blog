<?php

include_once __DIR__.'/composer/vendor/autoload.php';

use jugger\Autoloader;
use jugger\Application;

$autoloader = new Autoloader();
$autoloader->addNamespace('app', __DIR__);
$autoloader->register();

$di = include(__DIR__.'/config/di.php');
$di->checkDependencies([
	'jugger\Request',
	'jugger\UrlRewriter',
]);

$params = include(__DIR__.'/config/params.php');
$urlRules = include(__DIR__.'/config/url-rules.php');
$eventManager = include(__DIR__.'/config/events.php');

$app = new Application($di, $params);
$app->setRootDir(__DIR__);
$app->setEventManager($eventManager);
$app->check();

$request = $di->createClass('jugger\Request');
$request->setParams($_GET);
$request->setData($_POST);

$urlRewriter = $di->createClass('jugger\UrlRewriter');
$urlRewriter->setRules($urlRules);
$urlRewriter->setRequest($request);

$request = $urlRewriter->getRequest();
$route = $urlRewriter->getRoute($_SERVER['REQUEST_URI']);
$app->runByRequest($route, $request);

exit();
