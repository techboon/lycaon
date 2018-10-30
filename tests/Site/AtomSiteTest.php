<?php

namespace Lycaon\FeedParts\Site;

use PHPUnit\Framework\TestCase;

class AtomSiteTest extends TestCase
{
	private $xml;

	public function setup()
	{
		$feed = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
<title>test-title</title>
<subtitle>test-subtitle</subtitle>
<id>id</id>
<link rel="alternate" href="https://github.com/techboon/lycaon"/>
<author>
<name>techboon</name>
</author>
<updated>2018-10-30T17:52:00+09:00</updated>
<rights>techboon 2018</rights>
<entry>
<title>test-entry-title</title>
<link href="https://github.com/techboon/lycaon/POST"/>
<id>1</id>
<published>2018-10-30T15:28:00+09:00</published>
<updated>2018-10-30T15:28:00+09:00</updated>
</entry>
</feed>
EOF;
		$this->xml = new \SimpleXmlElement($feed);
	}

	public function testParse()
	{
		$this->assertInstanceOf(
			AtomSite::class,
			AtomSite::parse($this->xml)
		);
	}

	public function testTitle()
	{
		$site = AtomSite::parse($this->xml);
		$this->assertSame(
			'test-title',
			$site->title()
		);
	}

	public function testUrl()
	{
		$site = AtomSite::parse($this->xml);
		$this->assertSame(
			'https://github.com/techboon/lycaon',
			$site->url()
		);
	}
}