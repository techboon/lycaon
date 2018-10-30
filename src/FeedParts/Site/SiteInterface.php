<?php

namespace Lycaon\FeedParts\Site;

use Lycaon\FeedParts\Post\Posts;

interface SiteInterface
{
	public static function parse(\SimpleXmlElement $xml): SiteInterface;
	public function title(): string;
	public function url(): string;

	public function posts(): Posts;
}