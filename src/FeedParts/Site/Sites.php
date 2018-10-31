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