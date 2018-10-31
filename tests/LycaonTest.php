<?php

namespace Lycaon;

use Lycaon\FeedParts\Post\AtomPost;
use Lycaon\FeedParts\Post\Posts;
use Lycaon\FeedParts\Post\Rss2Post;
use Lycaon\FeedParts\Site\AtomSite;
use Lycaon\FeedParts\Site\Rss2Site;
use Lycaon\FeedParts\Site\Sites;
use PHPUnit\Framework\TestCase;

class LycaonTest extends TestCase
{
	public function testAtom()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('https://gihyo.jp/feed/atom')
		);

		$this->assertInstanceOf(
			AtomSite::class,
			$l->site()
		);

		$this->assertInstanceOf(
			Posts::class,
			$l->posts()
		);

		$this->assertInstanceOf(
			AtomPost::class,
			$l->posts()->first()
		);
	}

	public function testRss2()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('https://feedforall.com/sample-feed.xml')
		);

		$this->assertInstanceOf(
			Rss2Site::class,
			$l->site()
		);

		$this->assertInstanceOf(
			Posts::class,
			$l->posts()
		);

		$this->assertInstanceOf(
			Rss2Post::class,
			$l->posts()->first()
		);
	}
}
