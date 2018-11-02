<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

/**
 * post parser interface
 */
interface PostInterface
{
    public static function parseAll(\SimpleXmlElement $xml): array;
    public static function parse(\SimpleXmlElement $xml): PostInterface;
    public function title(): string;
    public function url(): string;
    public function date(): \DateTime;
}
