<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class VideoWriter
{
    /**
     * @var PlayerLocationWriter
     */
    private $playerLocationWriter;

    /**
     * @var GalleryLocationWriter
     */
    private $galleryLocationWriter;

    /**
     * @var RestrictionWriter
     */
    private $restrictionWriter;

    /**
     * @var UploaderWriter
     */
    private $uploaderWriter;

    /**
     * @var PlatformWriter
     */
    private $platformWriter;

    /**
     * @var PriceWriter
     */
    private $priceWriter;

    /**
     * @var TagWriter
     */
    private $tagWriter;

    public function __construct(
        PlayerLocationWriter $playerLocationWriter = null,
        GalleryLocationWriter $galleryLocationWriter = null,
        RestrictionWriter $restrictionWriter = null,
        UploaderWriter $uploaderWriter = null,
        PlatformWriter $platformWriter = null,
        PriceWriter $priceWriter = null,
        TagWriter $tagWriter = null
    ) {
        $this->playerLocationWriter = $playerLocationWriter ?: new PlayerLocationWriter();
        $this->galleryLocationWriter = $galleryLocationWriter ?: new GalleryLocationWriter();
        $this->restrictionWriter = $restrictionWriter ?: new RestrictionWriter();
        $this->uploaderWriter = $uploaderWriter ?: new UploaderWriter();
        $this->platformWriter = $platformWriter ?: new PlatformWriter();
        $this->priceWriter = $priceWriter ?: new PriceWriter();
        $this->tagWriter = $tagWriter ?: new TagWriter();
    }

    public function write(VideoInterface $video, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:video');

        $this->writeThumbnailLocation($xmlWriter, $video->thumbnailLocation());
        $this->writeTitle($xmlWriter, $video->title());
        $this->writeDescription($xmlWriter, $video->description());
        $this->writeContentLocation($xmlWriter, $video->contentLocation());
        $this->writePlayerLocation($xmlWriter, $video->playerLocation());
        $this->writeGalleryLocation($xmlWriter, $video->galleryLocation());
        $this->writeDuration($xmlWriter, $video->duration());
        $this->writePublicationDate($xmlWriter, $video->publicationDate());
        $this->writeExpirationDate($xmlWriter, $video->expirationDate());
        $this->writeRating($xmlWriter, $video->rating());
        $this->writeViewCount($xmlWriter, $video->viewCount());
        $this->writeFamilyFriendly($xmlWriter, $video->familyFriendly());
        $this->writeTags($xmlWriter, $video->tags());
        $this->writeCategory($xmlWriter, $video->category());
        $this->writeRestriction($xmlWriter, $video->restriction());
        $this->writePrices($xmlWriter, $video->prices());
        $this->writeRequiresSubscription($xmlWriter, $video->requiresSubscription());
        $this->writeUploader($xmlWriter, $video->uploader());
        $this->writePlatform($xmlWriter, $video->platform());
        $this->writeLive($xmlWriter, $video->live());

        $xmlWriter->endElement();
    }

    private function writeThumbnailLocation(\XMLWriter $xmlWriter, $thumbnailLocation)
    {
        $xmlWriter->startElement('video:thumbnail_loc');
        $xmlWriter->text($thumbnailLocation);
        $xmlWriter->endElement();
    }

    private function writeTitle(\XMLWriter $xmlWriter, $title)
    {
        $xmlWriter->startElement('video:title');
        $xmlWriter->text($title);
        $xmlWriter->endElement();
    }

    private function writeDescription(\XMLWriter $xmlWriter, $description)
    {
        $xmlWriter->startElement('video:description');
        $xmlWriter->text($description);
        $xmlWriter->endElement();
    }

    private function writeContentLocation(\XMLWriter $xmlWriter, $contentLocation = null)
    {
        if ($contentLocation === null) {
            return;
        }

        $xmlWriter->startElement('video:content_loc');
        $xmlWriter->text($contentLocation);
        $xmlWriter->endElement();
    }

    private function writePlayerLocation(\XMLWriter $xmlWriter, PlayerLocationInterface $playerLocation = null)
    {
        if ($playerLocation === null) {
            return;
        }

        $this->playerLocationWriter->write($playerLocation, $xmlWriter);
    }

    private function writeGalleryLocation(\XMLWriter $xmlWriter, GalleryLocationInterface $galleryLocation = null)
    {
        if ($galleryLocation === null) {
            return;
        }

        $this->galleryLocationWriter->write($galleryLocation, $xmlWriter);
    }

    /**
     * @param \XMLWriter $xmlWriter
     * @param int|null   $duration
     */
    private function writeDuration(\XMLWriter $xmlWriter, $duration = null)
    {
        if ($duration === null) {
            return;
        }

        $xmlWriter->startElement('video:duration');
        $xmlWriter->text($duration);
        $xmlWriter->endElement();
    }

    private function writePublicationDate(\XMLWriter $xmlWriter, \DateTimeInterface $publicationDate = null)
    {
        if ($publicationDate === null) {
            return;
        }

        $xmlWriter->startElement('video:publication_date');
        $xmlWriter->text($publicationDate->format('c'));
        $xmlWriter->endElement();
    }

    private function writeExpirationDate(\XMLWriter $xmlWriter, \DateTimeInterface $expirationDate = null)
    {
        if ($expirationDate === null) {
            return;
        }

        $xmlWriter->startElement('video:expiration_date');
        $xmlWriter->text($expirationDate->format('c'));
        $xmlWriter->endElement();
    }

    /**
     * @param \XMLWriter $xmlWriter
     * @param float|null $rating
     */
    private function writeRating(\XMLWriter $xmlWriter, $rating = null)
    {
        if ($rating === null) {
            return;
        }

        $xmlWriter->startElement('video:rating');
        $xmlWriter->text(number_format($rating, 1));
        $xmlWriter->endElement();
    }

    /**
     * @param \XMLWriter $xmlWriter
     * @param int|null   $viewCount
     */
    private function writeViewCount(\XMLWriter $xmlWriter, $viewCount = null)
    {
        if ($viewCount === null) {
            return;
        }

        $xmlWriter->startElement('video:view_count');
        $xmlWriter->text($viewCount);
        $xmlWriter->endElement();
    }

    /**
     * @param \XMLWriter  $xmlWriter
     * @param string|null $familyFriendly
     */
    private function writeFamilyFriendly(\XMLWriter $xmlWriter, $familyFriendly = null)
    {
        if ($familyFriendly === null) {
            return;
        }

        $xmlWriter->startElement('video:family_friendly');
        $xmlWriter->text($familyFriendly);
        $xmlWriter->endElement();
    }

    /**
     * @param \XMLWriter     $xmlWriter
     * @param TagInterface[] $tags
     */
    private function writeTags(\XMLWriter $xmlWriter, array $tags)
    {
        foreach ($tags as $tag) {
            $this->tagWriter->write($tag, $xmlWriter);
        }
    }

    /**
     * @param \XMLWriter  $xmlWriter
     * @param string|null $category
     */
    private function writeCategory(\XMLWriter $xmlWriter, $category = null)
    {
        if ($category === null) {
            return;
        }

        $xmlWriter->startElement('video:category');
        $xmlWriter->text($category);
        $xmlWriter->endElement();
    }

    private function writeRestriction(\XMLWriter $xmlWriter, RestrictionInterface $restriction = null)
    {
        if ($restriction === null) {
            return;
        }

        $this->restrictionWriter->write($restriction, $xmlWriter);
    }

    /**
     * @param \XMLWriter       $xmlWriter
     * @param PriceInterface[] $prices
     */
    private function writePrices(\XMLWriter $xmlWriter, array $prices)
    {
        foreach ($prices as $price) {
            $this->priceWriter->write($price, $xmlWriter);
        }
    }

    /**
     * @param \XMLWriter  $xmlWriter
     * @param string|null $requiresSubscription
     */
    private function writeRequiresSubscription(\XMLWriter $xmlWriter, $requiresSubscription = null)
    {
        if ($requiresSubscription === null) {
            return;
        }

        $xmlWriter->startElement('video:requires_subscription');
        $xmlWriter->text($requiresSubscription);
        $xmlWriter->endElement();
    }

    private function writeUploader(\XMLWriter $xmlWriter, UploaderInterface $uploader = null)
    {
        if ($uploader === null) {
            return;
        }

        $this->uploaderWriter->write($uploader, $xmlWriter);
    }

    private function writePlatform(\XMLWriter $xmlWriter, PlatformInterface $platform = null)
    {
        if ($platform === null) {
            return;
        }

        $this->platformWriter->write($platform, $xmlWriter);
    }

    /**
     * @param \XMLWriter  $xmlWriter
     * @param string|null $live
     */
    private function writeLive(\XMLWriter $xmlWriter, $live = null)
    {
        if ($live === null) {
            return;
        }

        $xmlWriter->startElement('video:live');
        $xmlWriter->text($live);
        $xmlWriter->endElement();
    }
}
