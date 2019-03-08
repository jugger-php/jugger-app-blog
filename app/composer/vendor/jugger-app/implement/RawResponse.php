<?php

namespace jugger\implement;

use jugger\Response;

class RawResponse extends Response
{
	public function send()
	{
		echo $this->getData();
	}
}
