<?php
/**
 * lycaon rss/atom reader
 * author: techboon
 */

namespace Lycaon;

use GuzzleHttp\Client;
use Lycaon\FeedParts\Post\Posts;
use Lycaon\FeedParts\Site\Sites;

/**
 * Lycaon main
 */
class Lycaon
{
	/**
	 * @var GuzzleHttp\Client
	 */
	private static $singletonClient;

	/**
	 * @var Lycaon\FeedParts\Site\SiteInterface
	 */
	private $site;

	/**
	 * @var Lycaon\FeedParts\Post\Posts
	 */
	private $posts;

	/**
	 * read rss/atom feed from url
	 *
	 * @param string $url
	 * @return Lycaon
	 */
	public static function url(string $url): Lycaon
	{
		self::constructClient();
		$res = self::$singletonClient->request('GET', $url);
		$xml = new \SimpleXMLElement((string)$res->getBody());

		return new self($xml, $url);
	}

	/**
	 * @return Lycaon\FeedParts\Site\SiteInterface
	 */
	public function site()
	{
		return $this->site;
	}

	/**
	 * @return Lycaon\FeedParts\Post\Posts
	 */
	public function posts()
	{
		return $this->posts;
	}

	/**
	 * keep guzzle singleton
	 */
	private static function constructClient()
	{
		if (!isset(self::$singletonClient)) {
			self::$singletonClient = new Client();
		}
	}

	/**
	 * constructor
	 *
	 * @param \SimpleXMLElement $xml Feed xml
	 */
	private function __construct(\SimpleXMLElement $xml)
	{
		$this->site = Sites::parse($xml);
		$this->posts = Posts::parse($xml);
	}
}
