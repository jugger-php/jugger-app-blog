<?php

namespace jugger\implement;

use jugger\UrlRewriter;

class DefaultUrlRewriter extends UrlRewriter
{
	public function getRoute(string $url): ?string
	{
		foreach ($this->rules as $template => $route) {
			$params = $this->processTemplate($template, $url);
			if ($params) {
				foreach ($params as $key => $value) {
					$this->getRequest()->setParam($key, $value);
				}
			}
			if ($params !== false) {
				return $route;
			}
		}
		return null;
	}

	public function processTemplate(string $template, string $url)
	{
		$url = explode('?', $url)[0];
		list($re, $params) = $this->createRegexp($template);
		if (preg_match_all($re, $url, $m)) {
			$ret = [];
			foreach ($params as $i => $name) {
				$ret[$name] = $m[$i+1][0];
			}
			return $ret;
		}
		return false;
	}

	public function createRegexp(string $template)
	{
		$parseRe = '/({([^\}]+)})/';
		$paramNames = [];
		if (preg_match_all($parseRe, $template, $matches, \PREG_SET_ORDER, 0)) {
			$i=0;
			$templateReplace = [];
			$tmpTemplateReplace = [];
			foreach ($matches as $m) {
				$paramReplace = $m[1];
				$paramInfo = explode(':', $m[2]);
				$paramName = $paramInfo[0];
				$paramRe = $paramInfo[1] ?? '[^\/]+';

				$tmpTemplateReplace[$paramReplace] = "~{$i}~";
				$templateReplace[] = "({$paramRe})";
				$paramNames[] = $paramName;
				$i++;
			}
			$template = str_replace(
				array_keys($tmpTemplateReplace),
				array_values($tmpTemplateReplace),
				$template
			);
			$re = preg_quote($template, '/');
			$re = str_replace(
				array_values($tmpTemplateReplace),
				array_values($templateReplace),
				$re
			);
		}
		else {
			$re = preg_quote($template, '/');
		}
		return ["/^{$re}\/?$/i", $paramNames];
	}
}
