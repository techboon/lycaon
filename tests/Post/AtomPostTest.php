<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

use PHPUnit\Framework\TestCase;

class AtomPostTest extends TestCase
{
    private $atomFeed;

    public function setup()
    {
        $this->atomPost = <<<EOF
  <entry>
    <title>test-entry-title-2</title>
    <link href="https://github.com/techboon/lycaon/post-2"/>
    <id>2</id>
    <published>2018-10-30T15:28:00+09:00</published>
    <updated>2018-10-30T15:28:00+09:00</updated>
    <summary>fugafuga</summary>
  </entry>
EOF;

        $this->atomFeed = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>test-title</title>
  <subtitle>test-subtitle</subtitle>
  <id>id</id>
  <link href="https://github.com/techboon/lycaon"/>
  <author>
    <name>techboon</name>
  </author>
  <updated>2018-10-30T17:52:00+09:00</updated>
  <rights>techboon 2018</rights>
  <entry>
    <title>test-entry-title-1</title>
    <link href="https://github.com/techboon/lycaon/post-1"/>
    <id>1</id>
    <published>2018-10-30T15:28:00+09:00</published>
    <updated>2018-10-30T15:28:00+09:00</updated>
    <summary>hogehoge</summary>
  </entry>
  {$this->atomPost}
</feed>
EOF;
    }


    public function testParse()
    {
        $this->assertInstanceOf(
            AtomPost::class,
            $post = AtomPost::parse(new \SimpleXMLElement($this->atomPost))
        );
        return $post;
    }

    public function testParseAll()
    {
        $this->assertInternalType(
            'array',
            $posts = AtomPost::parseAll(new \SimpleXMLElement($this->atomFeed))
        );
    }

    /**
     * @depends testParse
     */
    public function testTitle(AtomPost $post)
    {
        $this->assertSame(
            'test-entry-title-2',
            $post->title()
        );
    }

    /**
     * @depends testParse
     */
    public function testUrl(AtomPost $post)
    {
        $this->assertSame(
            'https://github.com/techboon/lycaon/post-2',
            $post->url()
        );
    }

    /**
     * @depends testParse
     */
    public function testBody(AtomPost $post)
    {
        $this->assertSame(
            'fugafuga',
            $post->body()
        );
    }

    /**
     * @depends testParse
     */
    public function testDate(AtomPost $post)
    {
        $this->assertSame(
            (new \DateTime('2018-10-30T15:28:00+09:00'))->format('U'),
            ($post->date())->format('U')
        );
    }

    /**
     * @depends testParse
     */
    public function testId(AtomPost $post)
    {
        $this->assertSame(
            '2',
            $post->id()
        );
    }
}
