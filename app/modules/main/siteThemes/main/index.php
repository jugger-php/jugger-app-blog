<?php

$di = $this->context->getDi();
$page = $this->widget;
$assetManager = $di->createClass('jugger\asset\AssetManager');

$assetManager->addJs("https://code.jquery.com/jquery-3.3.1.min.js", [
	'name' => 'jquery',
]);
$assetManager->addJs("https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js");
$assetManager->addJs("https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js");
$assetManager->addCss("https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css");

$assetManager->addJs(__DIR__.'/script.js');
$assetManager->addCss(__DIR__.'/style.css');

ob_get_clean();
ob_get_clean();
ob_get_clean();
echo '<pre>';
var_dump([
	$assetManager
]);
echo '</pre>';
die();

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title><?= $page->getTitle() ?></title>
		<?= $page->getMetasHtml() ?>
		<?= \jugger\asset\widget\PrintAsset::renderStatic($this->context, [
			'assets' => $assetManager->getAssets('head'),
		]) ?>
	</head>
	<body>
		<h1>
			Страница
		</h1>
		<div class="page-content">
			<?= $this->content ?>
		</div>
		<?= \jugger\asset\widget\PrintAsset::renderStatic($this->context, [
			'assets' => $assetManager->getAssets('end'),
		]) ?>
	</body>
</html>
