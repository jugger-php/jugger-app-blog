<?php

return [
	// news
	'/news/{code}-{id:\d+}' => '/blog/postView',
	'/news/' => '/blog/index',
	// pages
	'/{code:.+}' => '/pages/pageView',
	'/' => '/pages/mainPageView',
];
