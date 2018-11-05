<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

use PHPUnit\Framework\TestCase;

class Rss2PostTest extends TestCase
{
    private $rss2Feed;

    public function setup()
    {
        $this->rss2Post = <<<EOF
  <item>
    <title>test-item-title2</title>
    <link>https://github.com/techboon/lycaon/POST-2</link>
    <description>test-item-description-2</description>
    <pubDate>Tue, 15 Oct 2018 15:28:00 +0900</pubDate>
  </item>
EOF;

        $this->rss2Feed = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
  <title>test-title</title>
  <link>https://github.com/techboon/lycaon</link>
  <description>test-description</description>
  <language>ja-jp</language>
  <copyright>techboon 2018</copyright>
  <lastBuildDate>Tue, 30 Oct 2018 17:52:00 +0900</lastBuildDate>
  <item>
    <title>test-item-title</title>
    <link>https://github.com/techboon/lycaon/POST</link>
    <description>test-item-description</description>
    <pubDate>Tue, 30 Oct 2018 15:28:00 +0900</pubDate>
  </item>
{$this->rssPost}
</channel>
</rss>
EOF;
    }


    public function testParse()
    {
        $this->assertInstanceOf(
            Rss2Post::class,
            $post = Rss2Post::parse(new \SimpleXMLElement($this->rss2Post))
        );
        return $post;
    }

    public function testParseAll()
    {
        $this->assertInternalType(
            'array',
            $posts = Rss2Post::parseAll(new \SimpleXMLElement($this->rss2Feed))
        );
    }

    /**
     * @depends testParse
     */
    public function testTitle(Rss2Post $post)
    {
        $this->assertSame(
            'test-item-title2',
            $post->title()
        );
    }

    /**
     * @depends testParse
     */
    public function testUrl(Rss2Post $post)
    {
        $this->assertSame(
            'https://github.com/techboon/lycaon/POST-2',
            $post->url()
        );
    }

    /**
     * @depends testParse
     */
    public function testBody(Rss2Post $post)
    {
        $this->assertSame(
            'test-item-description-2',
            $post->body()
        );
    }

    /**
     * @depends testParse
     */
    public function testDate(Rss2Post $post)
    {
        $this->assertSame(
            (new \DateTime('Tue, 15 Oct 2018 15:28:00 +0900'))->format('U'),
            ($post->date())->format('U')
        );
        $this->assertSame(
            '2018/10',
            ($post->date())->format('Y/m')
        );
    }

    /**
     * @depends testParse
     */
    public function testId(Rss2Post $post)
    {
        $this->assertSame(
            '19fdc8324f7f4988',
            $post->id()
        );
    }
}
