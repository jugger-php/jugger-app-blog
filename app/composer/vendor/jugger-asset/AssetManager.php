<?php

namespace jugger\asset;

abstract class AssetManager
{
	protected $assets;

	public function getAssets(string $position): array
	{
		return $this->assets[$position] ?? [];
	}

	public function addAsset(Asset $asset, string $position)
	{
		if ($asset->isLocal()) {
			$url = $this->publish($asset);
		}
		else {
			$url = $asset->getPath();
		}
		$asset->setUrl($url);

		$name = $asset->getName();
		$list = (array) ($this->assets[$position] ?? []);
		$list[$name] = $asset;
		$this->assets[$position] = $list;
	}

	public function addJs(string $path, array $options = [])
	{
		$options['type'] = 'js';
		$asset = Asset::build($path, $options);

		$position = $options['position'] ?? 'end';
		$this->addAsset($asset, $position);
	}

	public function addCss(string $path, array $options = [])
	{
		$options['type'] = 'css';
		$asset = Asset::build($path, $options);

		$position = $options['position'] ?? 'head';
		$this->addAsset($asset, $position);
	}

	/**
	 * Размещение ресурса в публичной части
	 * Возвращает путь относительно DOCUMENT_ROOT
	 */
	abstract public function publish(Asset $asset): string;
}
