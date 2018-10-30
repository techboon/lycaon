<?php

namespace Lycaon\FeedParts\Site;

use Lycaon\FeedParts\Post\Posts;

class Rss2Site implements SiteInterface
{
	private $content;
	private $posts;

	private function __construct(\SimpleXmlElement $xml)
	{
		$this->content = $xml;
		$this->posts = null;
	}

	public static function parse(\SimpleXmlElement $xml): SiteInterface
	{
		return new self($xml);
	}

	public function title(): string
	{
		return strval($this->content->channel->title);
	}

	public function url(): string
	{
		return strval($this->content->channel->link);
	}

	public function posts(): Posts
	{
		if (is_null($this->posts)) {
			$this->posts = Posts::parse($this->content);
		}
		return $this->posts;
	}
}
