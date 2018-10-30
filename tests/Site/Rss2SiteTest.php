<?php

namespace Lycaon\FeedParts\Site;

use PHPUnit\Framework\TestCase;

class Rss2SiteTest extends TestCase
{
	private $xml;

	public function setup()
	{
		$feed = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
<title>test-title</title>
<link>https://github.com/techboon/lycaon</link>
<description>test-description</description>
<language>ja-jp</language>
<copyright>techboon 2018</copyright>
<lastBuildDate>Tue, 30 Oct 2018 17:52:00 +0900</lastBuildDate>
<item>
<title>test-item-title</title>
<link>https://github.com/techboon/lycaon/POST</link>
<description>test-item-description</description>
<pubDate>Tue, 30 Oct 2018 15:28:00 +0900</pubDate>
</item>
</channel>
</rss>
EOF;
		$this->xml = new \SimpleXmlElement($feed);
	}

	public function testParse()
	{
		$this->assertInstanceOf(
			Rss2Site::class,
			Rss2Site::parse($this->xml)
		);
	}

	public function testTitle()
	{
		$site = Rss2Site::parse($this->xml);
		$this->assertSame(
			'test-title',
			$site->title()
		);
	}

	public function testUrl()
	{
		$site = Rss2Site::parse($this->xml);
		$this->assertSame(
			'https://github.com/techboon/lycaon',
			$site->url()
		);
	}
}