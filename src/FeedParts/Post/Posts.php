<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

/**
 * rss/atom post parser
 */
class Posts implements \IteratorAggregate
{
    private $posts;

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->posts);
    }

    private function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public static function parse(\SimpleXmlElement $xml): Posts
    {
        if (isset($xml->entry)) {
            $posts = AtomPost::parseAll($xml->entry);
        } elseif (isset($xml->item)) {
            $posts = Rss1Post::parseAll($xml->item);
        } elseif (isset($xml->channel) && isset($xml->channel->item)) {
            $posts = Rss2Post::parseAll($xml->channel->item);
        }
        return new self($posts);
    }

    public function first(): ?PostInterface
    {
        return $this->get(0);
    }

    public function get(int $num): ?PostInterface
    {
        if (count($this->posts) < $num) {
            return null;
        }
        return $this->posts[$num];
    }
}
