<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Site;

use Lycaon\FeedParts\Post\Posts;

/**
 * rss2 feed parser
 */
class Rss2Site implements SiteInterface
{
    private $content;
    private $url;

    private function __construct(\SimpleXmlElement $xml)
    {
        $this->content = $xml;
        $this->url = null;
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
}
