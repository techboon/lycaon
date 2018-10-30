<?php

namespace Lycaon;

use PHPUnit\Framework\TestCase;
use Lycaon\FeedParts\Site\Sites;
use Lycaon\FeedParts\Site\AtomSite;
use Lycaon\FeedParts\Site\Rss2Site;

class LycaonTest extends TestCase
{
	public function testAtom()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('atom_feed_url')
		);

		$this->assertInstanceOf(
			AtomSite::class,
			$l->site()
		);
		
		// sample: list by post titles
		// foreach ($l->site()->posts() as $post) {
		// 	var_dump($post->title());
		// }
	}

	public function testRss2()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('rss2_feed_url')
		);

		$this->assertInstanceOf(
			Rss2Site::class,
			$l->site()
		);
	}
}
