<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Site;

use Lycaon\FeedParts\Post\Posts;

/**
 * feed parser interface
 */
interface SiteInterface
{
    public static function parse(\SimpleXmlElement $xml): SiteInterface;
    public function title(): string;
    public function url(): string;
}