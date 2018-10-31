<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

/**
 * rss2 post parser
 */
class Rss2Post implements PostInterface
{
    private $content;

    private function __construct(\SimpleXmlElement $xml)
    {
        $this->content = $xml;
    }

    public static function parseAll(\SimpleXmlElement $xml): array
    {
        $posts = [];
        foreach ($xml as $item) {
            $posts[] = self::parse($item);
        }
        return $posts;
    }

    public static function parse(\SimpleXmlElement $xml): PostInterface
    {
        return new self($xml);
    }

    public function title(): string
    {
        return strval($this->content->title);
    }

    public function url(): string
    {
        return strval($this->content->link);
    }

    public function body(): string
    {
        return strval($this->content->description);
    }
}
