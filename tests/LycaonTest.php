<?php

namespace Lycaon;

use PHPUnit\Framework\TestCase;
use Lycaon\FeedParts\Site\Sites;

class LycaonTest extends TestCase
{
	public function test()
	{
		$this->assertInstanceOf(
			Lycaon::class,
			$l = Lycaon::url('atom_or_rss2_feed_url')
		);

		$this->assertInstanceOf(
			Sites::class,
			$sites = $l->sites()
		);
		
		// sample: list by post titles
		foreach ($l->sites() as $site) {
			foreach ($site->posts() as $post) {
				var_dump($post->title());
			}
		}
	}
}
