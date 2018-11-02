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
    <title>test-entry-title-1</title>
    <link href="https://github.com/techboon/lycaon/post-1"/>
    <id>1</id>
    <published>2018-10-30T15:28:00+09:00</published>
    <updated>2018-10-30T15:28:00+09:00</updated>
  </entry>
  <entry>
    <title>test-entry-title-2</title>
    <link href="https://github.com/techboon/lycaon/post-2"/>
    <id>2</id>
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
      <title>test-item-title-1</title>
      <link>https://github.com/techboon/lycaon/post-1</link>
      <description>test-item-description</description>
      <pubDate>Tue, 30 Oct 2018 15:28:00 +0900</pubDate>
    </item>
    <item>
      <title>test-item-title-2</title>
      <link>https://github.com/techboon/lycaon/post-2</link>
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
		return $posts;
	}

	/**
	 * @depends testParseAtom
	 */
	public function testFirstAtom(Posts $posts)
	{
		$this->assertInstanceOf(
			AtomPost::class,
			$posts->first()
		);

		$this->assertSame(
			'test-entry-title-1',
			$posts->first()->title()
		);

		$this->assertSame(
			'https://github.com/techboon/lycaon/post-1',
			$posts->first()->url()
		);
	}

	/**
	 * @depends testParseAtom
	 */
	public function testGetAtom(Posts $posts)
	{
		$this->assertSame(
			$posts->first(),
			$posts->get(0)
		);

		$post = $posts->get(1);
		$this->assertSame(
			'test-entry-title-2',
			$post->title()
		);

		$this->assertSame(
			'https://github.com/techboon/lycaon/post-2',
			$post->url()
		);
	}

	public function testParseRss2()
	{
		$xml = new \SimpleXmlElement($this->rss2Feed);
		$this->assertInstanceOf(
			Posts::class,
			$posts = Posts::parse($xml)
		);
		return $posts;
	}

	/**
	 * @depends testParseRss2
	 */
	public function testFirstRss2(Posts $posts)
	{
		$this->assertInstanceOf(
			Rss2Post::class,
			$posts->first()
		);

		$this->assertSame(
			'test-item-title-1',
			$posts->first()->title()
		);

		$this->assertSame(
			'https://github.com/techboon/lycaon/post-1',
			$posts->first()->url()
		);
	}

	/**
	 * @depends testParseRss2
	 */
	public function testGetRss2(Posts $posts)
	{
		$this->assertSame(
			$posts->first(),
			$posts->get(0)
		);

		$post = $posts->get(1);
		$this->assertSame(
			'test-item-title-2',
			$post->title()
		);

		$this->assertSame(
			'https://github.com/techboon/lycaon/post-2',
			$post->url()
		);
	}
}