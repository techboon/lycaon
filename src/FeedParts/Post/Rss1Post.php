<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

/**
 * rss1 post parser
 */
class Rss1Post implements PostInterface
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

    public function id(): string
    {
        $s = md5($this->title() . $this->url());
        return substr($s, 0, 16);
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

    public function date(): \DateTime
    {
        $date = strval($this->content->children('http://purl.org/dc/elements/1.1/')->date);
        return new \DateTime($date);
    }
}
