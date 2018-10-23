<?php

namespace Lycaon;

use GuzzleHttp\Client;

class Lycaon
{
	private static $singletonClient;

	private static function constructClient()
	{
		if (!isset(self::$singletonClient)) {
			self::$singletonClient = new Client();
		}
	}

	public static function rss(string $url): Rss
	{
		return Rss::fromXml(
			self::get($url)
		);
	}

	private static function get(string $url): Rss
	{
		self::constructClient();

		$res = self::$singletonClient->request('GET', $url);
		
		switch($res->getHeaderLine('content-type')) {
			case 'application/atom+xml':
				return Rss::fromAtom($res->getBody());
				break;
			case 'application/rss+xml':
			case 'application/rdf+xml':
			case 'application/xml':
			case 'application/rdf+xml':
			default:
				return Rss::fromRss($res->getBody());
				break;
		}
	}
}
