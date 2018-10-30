<?php

namespace Lycaon;

use GuzzleHttp\Client;
use Lycaon\FeedParts\Site\Sites;
use Lycaon\FeedParts\Post\Posts;

class Lycaon
{
	private static $singletonClient;

	private $url;
	private $site;
	private $posts;

	private static function constructClient()
	{
		if (!isset(self::$singletonClient)) {
			self::$singletonClient = new Client();
		}
	}

	public static function url(string $url)
	{
		self::constructClient();
		$res = self::$singletonClient->request('GET', $url);
		$xml = new \SimpleXMLElement((string)$res->getBody());

		return new self($xml, $url);
	}

	private function __construct(\SimpleXMLElement $xml, string $url = null)
	{
		$this->url = $url;
		$this->site = Sites::parse($xml);
		$this->posts = Posts::parse($xml);
	}

	public function site()
	{
		return $this->site;
	}

	public function posts()
	{
		return $this->posts;
	}
}
