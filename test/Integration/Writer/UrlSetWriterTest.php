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
        $urlSet = new Component\UrlSet([
            new Component\Url('http://www.example.com/foo.html'),
        ]);

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
        $url = new Component\Url('http://www.example.com/foo.html');

        $image = new Component\Image\Image('http://example.com/image.jpg');
        $image = $image->withCaption('Dogs playing poker');

        $anotherImage = new Component\Image\Image('http://example.com/image2.jpg');
        $anotherImage = $anotherImage
            ->withTitle('Herbert')
            ->withCaption('Big dog plays his cards')
            ->withGeoLocation('At the table')
            ->withLicence('Public Domain');

        $news = new Component\News\News(
            new Component\News\Publication(
                'The National Park Gazette',
                'en_US'
            ),
            new \DateTimeImmutable('2016-02-29T12:00:00+00:00'),
            'Drive to Park ends well'
        );

        $news = $news
            ->withAccess(Component\News\NewsInterface::ACCESS_REGISTRATION)
            ->withGenres([
                Component\News\NewsInterface::GENRE_BLOG,
                Component\News\NewsInterface::GENRE_OPINION,
            ])
            ->withKeywords([
                'dog',
                'park',
                'accident',
            ])
            ->withStockTickers([
                'GM',
                'AAPL',
            ]);

        $video = new Component\Video\Video(
            'http://www.example.com/thumbs/123.jpg',
            'Grilling steaks for summer',
            'Cook the perfect steak every time.',
            'http://www.example.com/video123.flv'
        );

        $playerLocation = new Component\Video\PlayerLocation('http://www.example.com/videoplayer.swf?video=234');
        $playerLocation = $playerLocation
            ->withAllowEmbed(Component\Video\PlayerLocationInterface::ALLOW_EMBED_YES)
            ->withAutoPlay('ap=1');

        $anotherVideo = new Component\Video\Video(
            'http://www.example.com/thumbs/234.jpg',
            'Driving to the park',
            'When driving to the park, you need to be careful to turn at the right intersection, otherwise you miss it',
            'http://www.example.com/video234.flv',
            $playerLocation
        );

        $platform = new Component\Video\Platform(Component\Video\PlatformInterface::RELATIONSHIP_ALLOW);
        $platform = $platform->withTypes([
            Component\Video\PlatformInterface::TYPE_MOBILE,
            Component\Video\PlatformInterface::TYPE_WEB,
        ]);

        $galleryLocation = new Component\Video\GalleryLocation('http://www.example.com/gallery/234');
        $galleryLocation = $galleryLocation->withTitle('Snapshots during our drive to the park');

        $restriction = new Component\Video\Restriction(Component\Video\RestrictionInterface::RELATIONSHIP_DENY);
        $restriction = $restriction->withCountryCodes([
            'de_DE',
            'fr_FR',
        ]);

        $anotherVideo = $anotherVideo
            ->withGalleryLocation($galleryLocation)
            ->withDuration(65)
            ->withPublicationDate(new \DateTimeImmutable('2016-03-01T15:39:12+00:00'))
            ->withExpirationDate(new \DateTimeImmutable('2016-12-31T00:00:00+00:00'))
            ->withRating(3.5)
            ->withViewCount(9000)
            ->withTags([
                new Component\Video\Tag('park'),
                new Component\Video\Tag('car'),
                new Component\Video\Tag('dog'),
            ])
            ->withCategory('leisure')
            ->withRestriction($restriction)
            ->withPrices([
                new Component\Video\Price(0.99, 'USD'),
                new Component\Video\Price(1.35, 'CAD'),
             ])
            ->withRequiresSubscription(Component\Video\VideoInterface::REQUIRES_SUBSCRIPTION_NO)
            ->withUploader(new Component\Video\Uploader('Jane Doe'))
            ->withPlatform($platform)
            ->withLive(Component\Video\VideoInterface::LIVE_NO);

        $url = $url
            ->withPriority(0.8)
            ->withImages([
                $image,
                $anotherImage,
            ])
            ->withNews([
                $news,
            ])
            ->withVideos([
                $video,
                $anotherVideo,
            ]);

        $urlSet = new Component\UrlSet([
           $url,
        ]);

        $writer = new Writer\UrlSetWriter();

        $expected = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url>
        <loc>http://www.example.com/foo.html</loc>
        <priority>0.8</priority>
        <image:image>
            <image:loc>http://example.com/image.jpg</image:loc>
            <image:caption>Dogs playing poker</image:caption>
        </image:image>
        <image:image>
            <image:loc>http://example.com/image2.jpg</image:loc>
            <image:title>Herbert</image:title>
            <image:caption>Big dog plays his cards</image:caption>
            <image:geo_location>At the table</image:geo_location>
            <image:licence>Public Domain</image:licence>
        </image:image>
        <news:news>
            <news:publication>
                <news:name>The National Park Gazette</news:name>
                <news:language>en_US</news:language>
            </news:publication>
            <news:publication_date>2016-02-29T12:00:00+00:00</news:publication_date>
            <news:title>Drive to Park ends well</news:title>
            <news:access>Registration</news:access>
            <news:genres>Blog, Opinion</news:genres>
            <news:keywords>dog, park, accident</news:keywords>
            <news:stock_tickers>GM, AAPL</news:stock_tickers>
        </news:news>
        <video:video>
            <video:thumbnail_loc>http://www.example.com/thumbs/123.jpg</video:thumbnail_loc>
            <video:title>Grilling steaks for summer</video:title>
            <video:description>Cook the perfect steak every time.</video:description>
            <video:content_loc>http://www.example.com/video123.flv</video:content_loc>
        </video:video>
        <video:video>
            <video:thumbnail_loc>http://www.example.com/thumbs/234.jpg</video:thumbnail_loc>
            <video:title>Driving to the park</video:title>
            <video:description>When driving to the park, you need to be careful to turn at the right intersection, otherwise you miss it</video:description>
            <video:content_loc>http://www.example.com/video234.flv</video:content_loc>
            <video:player_loc allow_embed="yes" autoplay="ap=1">http://www.example.com/videoplayer.swf?video=234</video:player_loc>
            <video:gallery_loc title="Snapshots during our drive to the park">http://www.example.com/gallery/234</video:gallery_loc>
            <video:duration>65</video:duration>
            <video:publication_date>2016-03-01T15:39:12+00:00</video:publication_date>
            <video:expiration_date>2016-12-31T00:00:00+00:00</video:expiration_date>
            <video:rating>3.5</video:rating>
            <video:view_count>9000</video:view_count>
            <video:tag>park</video:tag>
            <video:tag>car</video:tag>
            <video:tag>dog</video:tag>
            <video:category>leisure</video:category>
            <video:restriction relationship="deny">de_DE fr_FR</video:restriction>
            <video:price currency="USD">0.99</video:price>
            <video:price currency="CAD">1.35</video:price>
            <video:requires_subscription>no</video:requires_subscription>
            <video:uploader>Jane Doe</video:uploader>
            <video:platform relationship="allow">mobile web</video:platform>
            <video:live>no</video:live>
        </video:video>
    </url>
</urlset>
XML;

        $this->assertXmlStringEqualsXmlString($expected, $writer->write($urlSet));
    }
}
