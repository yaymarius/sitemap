<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Integration\Writer;

use Refinery29\Sitemap\Component;
use Refinery29\Sitemap\Writer;

class UrlSetWriterTest extends \PHPUnit_Framework_TestCase
{
    public function testWriteSimpleSitemap()
    {
        $urlSet = new Component\UrlSet();

        $urlSet->addUrl(new Component\Url('http://www.example.com/foo.html'));

        $writer = new Writer\UrlSetWriter();

        $expected = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url>
        <loc>http://www.example.com/foo.html</loc>
    </url>
</urlset>
XML;

        $this->assertXmlStringEqualsXmlString($expected, $writer->write($urlSet));
    }

    public function testWriteSitemapWithMoreComponents()
    {
        $urlSet = new Component\UrlSet();

        $url = new Component\Url('http://www.example.com/foo.html');

        $image = new Component\Image\Image('http://example.com/image.jpg');
        $image = $image->withCaption('Dogs playing poker');

        $url = $url->withImages([
            $image,
        ]);

        $playerLocation = new Component\Video\PlayerLocation('http://www.example.com/videoplayer.swf?video=123');

        $playerLocation = $playerLocation
            ->withAllowEmbed(Component\Video\PlayerLocationInterface::ALLOW_EMBED_YES)
            ->withAutoPlay('ap=1')
        ;

        $video = new Component\Video\Video(
            'http://www.example.com/thumbs/123.jpg',
            'Grilling steaks for summer',
            'Cook the perfect steak every time.',
            'http://www.example.com/video123.flv',
            $playerLocation
        );

        $url = $url->withVideos([
            $video,
        ]);

        $urlSet->addUrl($url);

        $writer = new Writer\UrlSetWriter();

        $expected = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url>
        <loc>http://www.example.com/foo.html</loc>
        <image:image>
            <image:loc>http://example.com/image.jpg</image:loc>
            <image:caption>Dogs playing poker</image:caption>
        </image:image>
        <video:video>
            <video:thumbnail_loc>http://www.example.com/thumbs/123.jpg</video:thumbnail_loc>
            <video:title>Grilling steaks for summer</video:title>
            <video:description>Cook the perfect steak every time.</video:description>
            <video:content_loc>http://www.example.com/video123.flv</video:content_loc>
            <video:player_loc allow_embed="yes" autoplay="ap=1">http://www.example.com/videoplayer.swf?video=123</video:player_loc>
        </video:video>
    </url>
</urlset>
XML;

        $this->assertXmlStringEqualsXmlString($expected, $writer->write($urlSet));
    }
}
