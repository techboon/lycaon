<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

/**
 * atom post parser
 */
class AtomPost implements PostInterface
{
    private $content;

    private $url;

    private function __construct(\SimpleXmlElement $xml)
    {
        $this->content = $xml;
        $this->url = null;
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

    public function body(): string
    {
        return strval($this->content->description);
    }
}
