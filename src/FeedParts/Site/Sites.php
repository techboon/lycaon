<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Site;

/**
 * rss/atom feed parser
 */
class Sites
{
    public static function parse(\SimpleXmlElement $xml): SiteInterface
    {
        if (isset($xml->entry)) {
            return AtomSite::parse($xml);
        } elseif (isset($xml->item)) {
            return Rss1Site::parse($xml);
        } elseif (isset($xml->channel) && isset($xml->channel->item)) {
            return Rss2Site::parse($xml);
        }
    }
}
