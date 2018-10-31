<?php

namespace Lycaon\FeedParts\Post;

use PHPUnit\Framework\TestCase;

class PostsTest extends TestCase
{
private $atomFeed;
	private $rss2Feed;

	public function setup()
	{
		$this->atomFeed = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
<title>test-title</title>
<subtitle>test-subtitle</subtitle>
<id>id</id>
<link href="https://github.com/techboon/lycaon"/>
<author>
<name>techboon</name>
</author>
<updated>2018-10-30T17:52:00+09:00</updated>
<rights>techboon 2018</rights>
<entry>
<title>test-entry-title</title>
<link href="https://github.com/techboon/lycaon"/>
<id>1</id>
<published>2018-10-30T15:28:00+09:00</published>
<updated>2018-10-30T15:28:00+09:00</updated>
</entry>
</feed>
EOF;

		$this->rss2Feed = <<<EOF
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
<link>https://github.com/techboon/lycaon</link>
<description>test-item-description</description>
<pubDate>Tue, 30 Oct 2018 15:28:00 +0900</pubDate>
</item>
</channel>
</rss>
EOF;

	}

	public function testParseAtom()
	{
		$xml = new \SimpleXmlElement($this->atomFeed);
		$this->assertInstanceOf(
			Posts::class,
			$posts = Posts::parse($xml)
		);

		$this->assertInstanceOf(
			AtomPost::class,
			$posts->first()
		);
	}

	public function testParseRss2()
	{
		$xml = new \SimpleXmlElement($this->rss2Feed);
		$this->assertInstanceOf(
			Posts::class,
			$posts = Posts::parse($xml)
		);

		$this->assertInstanceOf(
			Rss2Post::class,
			$posts->first()
		);
	}
}