<?php

namespace jugger\asset;

class Asset
{
	protected $url;
	protected $name;
	protected $type;
	protected $path;
	protected $depends;

	public function setUrl(string $url)
	{
		$this->url = $url;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getDepends(): array
	{
		return $this->depends;
	}

	public static function build(string $path, array $options = [])
	{
		$self = new static();
		$self->url = null;
		$self->path = $path;
		$self->type = (string) ($options['type'] ?? 'file');
		$self->name = (string) ($options['name'] ?? md5($path));
		$self->depends = (array) ($options['depends'] ?? []);
		return $self;
	}

	public function isLocal()
	{
		$basePath = $_SERVER['DOCUMENT_ROOT'];
		return stripos($this->path, $basePath) === 0;
	}
}
