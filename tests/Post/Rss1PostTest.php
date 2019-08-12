<?php
/**
 * Lycaon rss/atom reader
 *
 * @author techboon <varna@techboon.info>
 */

namespace Lycaon\FeedParts\Post;

use PHPUnit\Framework\TestCase;

class Rss1PostTest extends TestCase
{
    private $rss1Feed;

    public function setup()
    {
        $this->rss1Feed = <<<EOF
<?xml version="1.0" encoding="utf-8" ?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:mn="http://usefulinc.com/rss/manifest/"
  xml:lang="ja">
 <channel>
  <title>site-title</title>
  <link>https://github.com/techboon/lycaon</link>
  <description>lycaon description</description>
  <dc:language>ja-jp</dc:language>
  <dc:publisher>techboon</dc:publisher>
  <dc:rights>techboon 2018</dc:rights>
  <items>
   <rdf:Seq>
    <rdf:li rdf:resource="https://github.com/techboon/lycaon/POST-1"/>
    <rdf:li rdf:resource="https://github.com/techboon/lycaon/POST-2"/>
   </rdf:Seq>
  </items>
 </channel>
 <item rdf:about="https://github.com/techboon/lycaon/POST-1">
  <title>post-title</title>
  <link>https://github.com/techboon/lycaon/POST-1</link>
  <description>post description</description>
  <dc:date>2018-11-08T11:19:00+09:00</dc:date>
  <dc:subject>post subject</dc:subject>
  <dc:creator>post creator</dc:creator>
 </item>
 <item rdf:about="https://github.com/techboon/lycaon/POST-2">
  <title>post-title-2</title>
  <link>https://github.com/techboon/lycaon/POST-2</link>
  <description>post description 2</description>
  <dc:date>2018-11-15T12:22:23+09:00</dc:date>
  <dc:subject>post subject 2</dc:subject>
  <dc:creator>post creator 2</dc:creator>
 </item>
</rdf:RDF>
EOF;
    }


    public function testParse()
    {
        // RSS1 can not has fragmented part of item
        // because <item> tag having rdf attribute, this refference to the <rdf> parent.
        $feedXml = new \SimpleXMLElement($this->rss1Feed);
        $this->assertInstanceOf(
            Rss1Post::class,
            $post = Rss1Post::parse($feedXml->item[1])
        );
        return $post;
    }

    public function testParseAll()
    {
        $this->assertInternalType(
            'array',
            $posts = Rss1Post::parseAll(new \SimpleXMLElement($this->rss1Feed))
        );
    }

    /**
     * @depends testParse
     */
    public function testTitle(Rss1Post $post)
    {
        $this->assertSame(
            'post-title-2',
            $post->title()
        );
    }

    /**
     * @depends testParse
     */
    public function testUrl(Rss1Post $post)
    {
        $this->assertSame(
            'https://github.com/techboon/lycaon/POST-2',
            $post->url()
        );
    }

    /**
     * @depends testParse
     */
    public function testBody(Rss1Post $post)
    {
        $this->assertSame(
            'post description 2',
            $post->body()
        );
    }

    /**
     * @depends testParse
     */
    public function testDate(Rss1Post $post)
    {
        $this->assertSame(
            (new \DateTime('Thu, 15 Nov 2018 12:22:23 +0900'))->format('U'),
            ($post->date())->format('U')
        );
        $this->assertSame(
            '2018/11',
            ($post->date())->format('Y/m')
        );
    }

    /**
     * @depends testParse
     */
    public function testId(Rss1Post $post)
    {
        $this->assertSame(
            'd41d8cd98f00b204',
            $post->id()
        );
    }
}
