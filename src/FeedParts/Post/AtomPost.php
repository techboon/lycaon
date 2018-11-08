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

    public function id(): string
    {
        return strval($this->content->id);
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
            if (('alternate' === strval($link['rel'])) || (true !== isset($link['rel']))) {
                $this->url = strval($link['href']);
            }
        }
        return $this->url;
    }

    public function body(): string
    {
        return strval($this->content->summary);
    }

    public function date(): \DateTime
    {
        $date = strval($this->content->updated);
        return new \DateTime($date);
    }
}
