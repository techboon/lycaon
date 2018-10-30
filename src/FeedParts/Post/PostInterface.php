<?php

namespace Lycaon\FeedParts\Post;

interface PostInterface
{
	public static function parseAll(\SimpleXmlElement $xml): array;
	public static function parse(\SimpleXmlElement $xml): PostInterface;
	public function title(): string;
	public function url(): string;
}