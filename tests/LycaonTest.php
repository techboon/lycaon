<?php

namespace Lycaon;

use PHPUnit\Framework\TestCase;

class LycaonTest extends TestCase
{
	public function testRss()
	{
		$this->assertInstanceOf(
			RSS::class,
			Lycaon::rss('URL')
		);
	}
}
