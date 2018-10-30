<?php

namespace Lycaon\FeedParts\Site;

class Sites
{
	public static function parse(\SimpleXmlElement $xml)
	{
		if (isset($xml->entry)) {
			return AtomSite::parse($xml);
		} elseif (isset($xml->item)) {
			// var_dump('RSS1');
		} elseif (isset($xml->channel) && isset($xml->channel->item)) {
			return Rss2Site::parse($xml);
		}
	}
}