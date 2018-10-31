<?php
/**
 * Lycaon rss/atom reader
 * PHP version 7.1
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon;

use GuzzleHttp\Client;
use Lycaon\FeedParts\Post\Posts;
use Lycaon\FeedParts\Site\Sites;
use Lycaon\FeedParts\Site\SiteInterface;

/**
 * Lycaon main
 */
class Lycaon
{
    /**
     * Guzzle http client
     *
     * @var GuzzleHttp\Client
     */
    private static $singletonClient;

    /**
     * Feed site
     *
     * @var Lycaon\FeedParts\Site\SiteInterface
     */
    private $site;

    /**
     * Feed posts
     *
     * @var Lycaon\FeedParts\Post\Posts
     */
    private $posts;

    /**
     * Read rss/atom feed from url
     *
     * @param string $url
     *
     * @return Lycaon
     */
    public static function url(string $url): Lycaon
    {
        self::constructClient();
        $res = self::$singletonClient->request('GET', $url);
        $xml = new \SimpleXMLElement((string) $res->getBody());

        return new self($xml, $url);
    }

    /**
     * Site
     *
     * @return SiteInterface
     */
    public function site(): SiteInterface
    {
        return $this->site;
    }

    /**
     * Posts
     *
     * @return Posts
     */
    public function posts(): Posts
    {
        return $this->posts;
    }

    /**
     * Keep guzzle singleton
     *
     * @return void
     */
    private static function constructClient(): void
    {
        if (true !== isset(self::$singletonClient)) {
            self::$singletonClient = new Client();
        }
    }

    /**
     * Constructor
     *
     * @param \SimpleXMLElement $xml Feed xml
     *
     * @return void
     */
    private function __construct(\SimpleXMLElement $xml)
    {
        $this->site  = Sites::parse($xml);
        $this->posts = Posts::parse($xml);
    }
}
