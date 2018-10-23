<?php

namespace Lycaon;

class Rss
{
	private $version = 2.0;
	public function __construct()
	{
		echo 'hoge';
	}

	public static function fromXml(\SimpleXMLElement $data): RSS
	{
		return new self();
	}
}
