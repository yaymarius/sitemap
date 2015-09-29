<?php

namespace Refinery29\Sitemap\Writer;

use DateTime;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Sitemap\Writer\Image\ImageWriter;
use Refinery29\Sitemap\Writer\News\NewsWriter;
use Refinery29\Sitemap\Writer\Video\VideoWriter;
use XMLWriter;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
class UrlWriter
{
    /**
     * @var ImageWriter
     */
    private $imageWriter;

    /**
     * @var NewsWriter
     */
    private $newsWriter;

    /**
     * @var VideoWriter
     */
    private $videoWriter;

    /**
     * @param ImageWriter $imageWriter
     * @param NewsWriter  $newsWriter
     * @param VideoWriter $videoWriter
     */
    public function __construct(
        ImageWriter $imageWriter = null,
        NewsWriter $newsWriter = null,
        VideoWriter $videoWriter = null
    ) {
        $this->imageWriter = $imageWriter ?: new ImageWriter();
        $this->newsWriter = $newsWriter ?: new NewsWriter();
        $this->videoWriter = $videoWriter ?: new VideoWriter();
    }

    /**
     * @param XMLWriter    $xmlWriter
     * @param UrlInterface $url
     */
    public function write(XMLWriter $xmlWriter, UrlInterface $url)
    {
        $xmlWriter->startElement('url');

        $this->writeLocation($xmlWriter, $url->getLocation());
        $this->writeLastModified($xmlWriter, $url->getLastModified());
        $this->writeChangeFrequency($xmlWriter, $url->getChangeFrequency());
        $this->writePriority($xmlWriter, $url->getPriority());
        $this->writeImages($xmlWriter, $url->getImages());
        $this->writeNews($xmlWriter, $url->getNews());
        $this->writeVideos($xmlWriter, $url->getVideos());

        $xmlWriter->endElement();
    }

    private function writeLocation(XMLWriter $xmlWriter, $location)
    {
        $xmlWriter->startElement('loc');
        $xmlWriter->text($location);
        $xmlWriter->endElement();
    }

    private function writeLastModified(XMLWriter $xmlWriter, DateTime $lastModified = null)
    {
        if ($lastModified === null) {
            return;
        }

        $xmlWriter->startElement('lastmod');
        $xmlWriter->text($lastModified->format('c'));
        $xmlWriter->endElement();
    }

    private function writeChangeFrequency(XMLWriter $xmlWriter, $changeFrequency = null)
    {
        if ($changeFrequency === null) {
            return;
        }

        $xmlWriter->startElement('changefreq');
        $xmlWriter->text($changeFrequency);
        $xmlWriter->endElement();
    }

    private function writePriority(XMLWriter $xmlWriter, $priority = null)
    {
        if ($priority === null) {
            return;
        }

        $xmlWriter->startElement('priority');
        $xmlWriter->text(number_format(2, $priority));
        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter        $xmlWriter
     * @param ImageInterface[] $images
     */
    private function writeImages(XMlWriter $xmlWriter, array $images = [])
    {
        foreach ($images as $image) {
            $this->imageWriter->write($xmlWriter, $image);
        }
    }

    /**
     * @param XMLWriter       $xmlWriter
     * @param NewsInterface[] $news
     */
    private function writeNews(XMlWriter $xmlWriter, array $news = [])
    {
        foreach ($news as $pieceOfNews) {
            $this->newsWriter->write($xmlWriter, $pieceOfNews);
        }
    }

    /**
     * @param XMLWriter        $xmlWriter
     * @param VideoInterface[] $videos
     */
    private function writeVideos(XMlWriter $xmlWriter, array $videos = [])
    {
        foreach ($videos as $video) {
            $this->videoWriter->write($xmlWriter, $video);
        }
    }
}
