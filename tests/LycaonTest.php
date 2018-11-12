<?php

namespace Lycaon;

use Lycaon\FeedParts\Post\AtomPost;
use Lycaon\FeedParts\Post\PostInterface;
use Lycaon\FeedParts\Post\Posts;
use Lycaon\FeedParts\Post\Rss1Post;
use Lycaon\FeedParts\Post\Rss2Post;
use Lycaon\FeedParts\Site\AtomSite;
use Lycaon\FeedParts\Site\Rss1Site;
use Lycaon\FeedParts\Site\Rss2Site;
use Lycaon\FeedParts\Site\SiteInterface;
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

	public function testRss1()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('https://gihyo.jp/dev/feed/rss1')
		);

		$this->assertInstanceOf(
			Rss1Site::class,
			$l->site()
		);

		$this->assertInstanceOf(
			Posts::class,
			$l->posts()
		);

		$this->assertInstanceOf(
			Rss1Post::class,
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

	public function feedUrlDataProvider()
	{
		return [
			[ 'https://gihyo.jp/feed/atom'],
			[ 'https://gihyo.jp/feed/rss1'],
			[ 'https://gihyo.jp/feed/rss2'],
			[ 'http://www.godac.jamstec.go.jp/darwin/static/xml/darwin_update_rss_j.xml' ],
			[ 'http://www.godac.jamstec.go.jp/darwin/static/xml/darwin_update_rss2_j.xml' ],
			[ 'http://www.godac.jamstec.go.jp/darwin/static/xml/darwin_update_atom_j.xml' ],
			[ 'https://www.youtube.com/feeds/videos.xml?channel_id=UCZf__ehlCEBPop-_sldpBUQ'],
			[ 'http://feed.japan.cnet.com/rss/index.rdf' ],
			[ 'http://www3.asahi.com/rss/index.rdf' ],
			[ 'http://agora.ex.nii.ac.jp/digital-typhoon/atom/ja.atom' ],
		];
	}

	/**
	 * @dataProvider feedUrlDataProvider
	 */
	public function testRealFeeds(string $url)
	{
		$feed = Lycaon::url($url);
		$this->assertTrue($feed->site() instanceof SiteInterface);
		$this->assertTrue($feed->posts()->first() instanceof PostInterface);
	}
}
