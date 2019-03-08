<?php

namespace jugger\widget;

class Page extends Widget
{
	protected $metas = [];
	protected $properties = [];

	public function setMeta(string $name, string $value, array $attributes = [])
	{
		$attributes['name'] = $name;
		$attributes['content'] = $value;
		$this->metas[$name] = $attributes;
	}

	public function getMeta(string $name): array
	{
		return $this->getMetas()[$name] ?? null;
	}

	public function getMetas(): array
	{
		return $this->metas;
	}

	public function getMetasHtml()
	{
		$ret = [];
		foreach ($this->getMetas() as $attributes) {
			$itemAttrs = "";
			foreach ($attributes as $key => $value) {
				$value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML401);
				$itemAttrs .= " {$key}='{$value}'";
			}
			$ret[] = "<meta {$itemAttrs}>";
		}
		return join("\n", $ret);
	}

	public function setProperty(string $name, $value)
	{
		$this->properties[$name] = $value;
	}

	public function getProperty(string $name)
	{
		return $this->properties[$name] ?? null;
	}

	public function getProperties(): array
	{
		return $this->properties;
	}

	public function setTitle(string $value)
	{
		$this->setProperty('title', $value);
	}

	public function getTitle()
	{
		return $this->getProperty('title');
	}
}
