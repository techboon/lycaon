<?php

namespace Lycaon\FeedParts\Post;

class Posts implements \IteratorAggregate
{
	private $posts;

	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->posts);
	}

	private function __construct(array $posts)
	{
		$this->posts = $posts;
	}

	public static function parse(\SimpleXmlElement $xml)
	{
		if (isset($xml->entry)) {
			$posts = AtomPost::parseAll($xml->entry);
		} elseif (isset($xml->item)) {
			// var_dump('RSS1');
		} elseif (isset($xml->channel) && isset($xml->channel->item)) {
			$posts = Rss2Post::parseAll($xml->channel->item);
		}
		return new self($posts);
	}

	public function first(): ?PostInterface
	{
		return $this->get(0);
	}

	public function get(int $num): ?PostInterface
	{
		if (count($this->posts) < $num) {
			return null;
		}
		return $this->posts[$num];
	}
}