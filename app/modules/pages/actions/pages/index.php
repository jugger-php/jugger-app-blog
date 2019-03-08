<?php

$di = $this->context->getDi();
$assetManager = $di->createClass('jugger\asset\AssetManager');

$this->setTitle("Главная страница");
$this->setMeta('keywords', 'ключи ключи ключи ключи ключи');
$this->setMeta('description', 'Описание \'\"\\""\\\'');
$this->setMeta('og:image', 'value', [
	'property' => 'og:image',
]);

$assetManager->addJs(__DIR__.'/script.js', [
	'depends' => [
		'jquery'
	],
]);
$assetManager->addJs('https://code.jquery.com/jquery-3.3.1.min.js', [
	'name' => 'jquery',
	'position' => 'end',
]);

$assetManager->addCss('https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css', [
	'name' => 'bootstrap',
	'position' => 'head',
]);

?>
главная страница
