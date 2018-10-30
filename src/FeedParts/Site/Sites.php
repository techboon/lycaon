<?php

namespace Lycaon\FeedParts\Site;

class Sites implements \IteratorAggregate
{
	private $sites;

	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->sites);
	}

	private function __construct(array $sites)
	{
		$this->sites = $sites;
	}

	public static function parse(\SimpleXmlElement $xml)
	{
		if (isset($xml->entry)) {
			$site = AtomSite::parse($xml);
		} elseif (isset($xml->item)) {
			// var_dump('RSS1');
		} elseif (isset($xml->channel) && isset($xml->channel->item)) {
			$site = Rss2Site::parse($xml);
		}
		return new self([$site]);
	}

	public function first(): ?SiteInterface
	{
		return $this->get(0);
	}

	public function get(int $num): ?SiteInterface
	{
		if (count($this->sites) < $num) {
			return null;
		}
		return $this->sites[$num];
	}
}