<?php

namespace Lycaon\FeedParts\Site;

use Lycaon\FeedParts\Post\Posts;

class AtomSite implements SiteInterface
{
	private $content;
	private $posts;
	private $url;

	private function __construct(\SimpleXmlElement $xml)
	{
		$this->content = $xml;
		$this->posts = null;
		$this->url = null;
	}

	public static function parse(\SimpleXmlElement $xml): SiteInterface
	{
		return new self($xml);
	}

	public function title(): string
	{
		return strval($this->content->title);
	}

	public function url(): string
	{
		if (!is_null($this->url)) {
			return $this->url;
		}

		$this->url = '';
		foreach ($this->content->link as $link) {
			if ('alternate' === strval($link['rel'])) {
				$this->url = strval($link['href']);
			}
		}
		return $this->url;
	}

	public function posts(): Posts
	{
		if (is_null($this->posts)) {
			$this->posts = Posts::parse($this->content);
		}
		return $this->posts;
	}
}
