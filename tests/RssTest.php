<?php

namespace Lycaon;

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
	public function testConstruct()
	{
		$lycaon = new RSS();
		$this->assertInstanceOf(
			RSS::class,
			$lycaon
		);
	}
}
