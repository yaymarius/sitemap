<?php

namespace Refinery29\Sitemap\Writer\Video;

use DateTime;
use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
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

    /**
     * @param PlayerLocationWriter  $playerLocationWriter
     * @param GalleryLocationWriter $galleryLocationWriter
     * @param RestrictionWriter     $restrictionWriter
     * @param UploaderWriter        $uploaderWriter
     * @param PlatformWriter        $platformWriter
     * @param PriceWriter           $priceWriter
     * @param TagWriter             $tagWriter
     */
    public function __construct(
        PlayerLocationWriter $playerLocationWriter,
        GalleryLocationWriter $galleryLocationWriter,
        RestrictionWriter $restrictionWriter,
        UploaderWriter $uploaderWriter,
        PlatformWriter $platformWriter,
        PriceWriter $priceWriter,
        TagWriter $tagWriter
    ) {
        $this->playerLocationWriter = $playerLocationWriter;
        $this->galleryLocationWriter = $galleryLocationWriter;
        $this->restrictionWriter = $restrictionWriter;
        $this->uploaderWriter = $uploaderWriter;
        $this->platformWriter = $platformWriter;
        $this->priceWriter = $priceWriter;
        $this->tagWriter = $tagWriter;
    }

    /**
     * @param XMLWriter      $xmlWriter
     * @param VideoInterface $video
     */
    public function write(XMLWriter $xmlWriter, VideoInterface $video)
    {
        $xmlWriter->startElement('video:video');

        $this->writeThumbnailLocation($xmlWriter, $video->getThumbnailLocation());
        $this->writeTitle($xmlWriter, $video->getTitle());
        $this->writeDescription($xmlWriter, $video->getDescription());
        $this->writeContentLocation($xmlWriter, $video->getContentLocation());
        $this->writePlayerLocation($xmlWriter, $video->getPlayerLocation());
        $this->writeGalleryLocation($xmlWriter, $video->getGalleryLocation());
        $this->writeDuration($xmlWriter, $video->getDuration());
        $this->writePublicationDate($xmlWriter, $video->getPublicationDate());
        $this->writeExpirationDate($xmlWriter, $video->getExpirationDate());
        $this->writeRating($xmlWriter, $video->getRating());
        $this->writeViewCount($xmlWriter, $video->getViewCount());
        $this->writeFamilyFriendly($xmlWriter, $video->getFamilyFriendly());
        $this->writeTags($xmlWriter, $video->getTags());
        $this->writeCategory($xmlWriter, $video->getCategory());
        $this->writeRestriction($xmlWriter, $video->getRestriction());
        $this->writePrices($xmlWriter, $video->getPrices());
        $this->writeRequiresSubscription($xmlWriter, $video->getRequiresSubscription());
        $this->writeUploader($xmlWriter, $video->getUploader());
        $this->writePlatform($xmlWriter, $video->getPlatform());
        $this->writeLive($xmlWriter, $video->getLive());

        $xmlWriter->endElement();
    }

    private function writeThumbnailLocation(XMLWriter $xmlWriter, $thumbnailLocation)
    {
        $xmlWriter->startElement('video:thumbnail_loc');
        $xmlWriter->text($thumbnailLocation);
        $xmlWriter->endElement();
    }

    private function writeTitle(XMLWriter $xmlWriter, $title)
    {
        $xmlWriter->startElement('video:title');
        $xmlWriter->text($title);
        $xmlWriter->endElement();
    }

    private function writeDescription(XMLWriter $xmlWriter, $description)
    {
        $xmlWriter->startElement('video:description');
        $xmlWriter->text($description);
        $xmlWriter->endElement();
    }

    private function writeContentLocation(XMLWriter $xmlWriter, $contentLocation = null)
    {
        if ($contentLocation === null) {
            return;
        }

        $xmlWriter->startElement('video:content_loc');
        $xmlWriter->text($contentLocation);
        $xmlWriter->endElement();
    }

    private function writePlayerLocation(XMLWriter $xmlWriter, PlayerLocationInterface $playerLocation = null)
    {
        if ($playerLocation === null) {
            return;
        }

        $this->playerLocationWriter->write($xmlWriter, $playerLocation);
    }

    private function writeGalleryLocation(XMLWriter $xmlWriter, GalleryLocationInterface $galleryLocation = null)
    {
        if ($galleryLocation === null) {
            return;
        }

        $this->galleryLocationWriter->write($xmlWriter, $galleryLocation);
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param int|null  $duration
     */
    private function writeDuration(XMLWriter $xmlWriter, $duration = null)
    {
        if ($duration === null) {
            return;
        }

        $xmlWriter->startElement('video:duration');
        $xmlWriter->text($duration);
        $xmlWriter->endElement();
    }

    private function writePublicationDate(XMLWriter $xmlWriter, DateTime $publicationDate = null)
    {
        if ($publicationDate === null) {
            return;
        }

        $xmlWriter->startElement('video:publication_date');
        $xmlWriter->text($publicationDate->format('c'));
        $xmlWriter->endElement();
    }

    private function writeExpirationDate(XMLWriter $xmlWriter, DateTime $expirationDate = null)
    {
        if ($expirationDate === null) {
            return;
        }

        $xmlWriter->startElement('video:expiration_date');
        $xmlWriter->text($expirationDate->format('c'));
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter  $xmlWriter
     * @param float|null $rating
     */
    private function writeRating(XMLWriter $xmlWriter, $rating = null)
    {
        if ($rating === null) {
            return;
        }

        $xmlWriter->startElement('video:rating');
        $xmlWriter->text(number_format($rating, 1));
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter $xmlWriter
     * @param int|null  $viewCount
     */
    private function writeViewCount(XMLWriter $xmlWriter, $viewCount = null)
    {
        if ($viewCount === null) {
            return;
        }

        $xmlWriter->startElement('video:view_count');
        $xmlWriter->text($viewCount);
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter   $xmlWriter
     * @param string|null $familyFriendly
     */
    private function writeFamilyFriendly(XMLWriter $xmlWriter, $familyFriendly = null)
    {
        if ($familyFriendly === null) {
            return;
        }

        $xmlWriter->startElement('video:family_friendly');
        $xmlWriter->text($familyFriendly);
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter      $xmlWriter
     * @param TagInterface[] $tags
     */
    private function writeTags(XMLWriter $xmlWriter, array $tags)
    {
        foreach ($tags as $tag) {
            $this->tagWriter->write($xmlWriter, $tag);
        }
    }

    /**
     * @param XMLWriter   $xmlWriter
     * @param string|null $category
     */
    private function writeCategory(XMLWriter $xmlWriter, $category = null)
    {
        if ($category === null) {
            return;
        }

        $xmlWriter->startElement('video:category');
        $xmlWriter->text($category);
        $xmlWriter->endElement();
    }

    private function writeRestriction(XMLWriter $xmlWriter, RestrictionInterface $restriction = null)
    {
        if ($restriction === null) {
            return;
        }

        $this->restrictionWriter->write($xmlWriter, $restriction);
    }

    /**
     * @param XMLWriter        $xmlWriter
     * @param PriceInterface[] $prices
     */
    private function writePrices(XMLWriter $xmlWriter, array $prices)
    {
        foreach ($prices as $price) {
            $this->priceWriter->write($xmlWriter, $price);
        }
    }

    /**
     * @param XMLWriter   $xmlWriter
     * @param string|null $requiresSubscription
     */
    private function writeRequiresSubscription(XMLWriter $xmlWriter, $requiresSubscription = null)
    {
        if ($requiresSubscription === null) {
            return;
        }

        $xmlWriter->startElement('video:requires_subscription');
        $xmlWriter->text($requiresSubscription);
        $xmlWriter->endElement();
    }

    private function writeUploader(XMLWriter $xmlWriter, UploaderInterface $uploader = null)
    {
        if ($uploader === null) {
            return;
        }

        $this->uploaderWriter->write($xmlWriter, $uploader);
    }

    private function writePlatform(XMLWriter $xmlWriter, PlatformInterface $platform = null)
    {
        if ($platform === null) {
            return;
        }

        $this->platformWriter->write($xmlWriter, $platform);
    }

    /**
     * @param XMLWriter   $xmlWriter
     * @param string|null $live
     */
    private function writeLive(XMLWriter $xmlWriter, $live = null)
    {
        if ($live === null) {
            return;
        }

        $xmlWriter->startElement('video:live');
        $xmlWriter->text($live);
        $xmlWriter->endElement();
    }
}
