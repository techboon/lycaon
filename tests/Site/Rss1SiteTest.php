<?php

namespace Lycaon\FeedParts\Site;

use PHPUnit\Framework\TestCase;

class Rss1SiteTest extends TestCase
{
	private $xml;

	public function setup()
	{
		$feed = <<<EOF
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
</rdf:RDF>
EOF;
		$this->xml = new \SimpleXmlElement($feed);
	}

	public function testParse()
	{
		$this->assertInstanceOf(
			Rss1Site::class,
			Rss1Site::parse($this->xml)
		);
	}

	public function testTitle()
	{
		$site = Rss1Site::parse($this->xml);
		$this->assertSame(
			'site-title',
			$site->title()
		);
	}

	public function testUrl()
	{
		$site = Rss1Site::parse($this->xml);
		$this->assertSame(
			'https://github.com/techboon/lycaon',
			$site->url()
		);
	}
}