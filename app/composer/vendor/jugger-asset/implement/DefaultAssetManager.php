<?php

namespace jugger\asset\implement;

use jugger\asset\Asset;
use jugger\asset\AssetManager;

class DefaultAssetManager extends AssetManager
{
	protected $publicFolderPath;

	public function __construct(string $publicFolderPath)
	{
		if (!file_exists($publicFolderPath)) {
			throw new \Exception("Папка для публичных ресурсов - не создана");
		}

		if (!is_dir($publicFolderPath)) {
			throw new \Exception("Папка для публичных ресурсов - не папка");
		}

		$this->publicFolderPath = rtrim($publicFolderPath, '/');
	}

	public function publish(Asset $asset): string
	{
		$assetPath = $asset->getPath();
		if (!file_exists($assetPath)) {
			throw new \Exception("Публикуемый файл '{$assetPath}' не найден");
		}

		$typeFolder = preg_replace('/[^a-z0-9\-\_]/i', '', $asset->getType());
		$typePath = $this->publicFolderPath.'/'.$typeFolder;

		if (!file_exists($typePath)) {
			@mkdir($typePath, 0644);
		}
		if (!is_dir($typePath)) {
			throw new \Exception("Создаваемая папка - не папка");
		}

		$hash = md5($asset->getName());
		$fileExtension = pathinfo($assetPath, \PATHINFO_EXTENSION);

		$fileName = $hash;
		if ($fileExtension) {
			$fileName .= ".{$fileExtension}";
		}

		$fileFolderName = substr($hash, 0, 3);
		$fileFolderPath = $typePath.'/'.$fileFolderName;
		if (!file_exists($fileFolderPath)) {
			@mkdir($fileFolderPath, 0644);
		}
		if (!is_dir($fileFolderPath)) {
			throw new \Exception("Создаваемая папка - не папка");
		}

		$publicPath = $fileFolderPath.'/'.$fileName;
		if (!file_exists($publicPath)) {
			copy($assetPath, $publicPath);
		}

		$basePath = realpath($_SERVER['DOCUMENT_ROOT']);
		$publicPath = realpath($publicPath);
		$url = str_replace($basePath, '', $publicPath);
		$url = str_replace('\\', '/', $url);
		return $url;
	}
}
