<?php

namespace Lycaon;

use GuzzleHttp\Client;
use Lycaon\FeedParts\Site\Sites;

class Lycaon
{
	private static $singletonClient;

	private $content;
	private $url;
	private $sites;

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
		$this->content = $xml;
		$this->sites = null;
	}

	public function sites()
	{
		if (is_null($this->sites)) {
			$this->sites = Sites::parse($this->content);
		}

		return $this->sites;
	}
}
