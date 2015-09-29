<?php

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\Image\Image;
use Refinery29\Sitemap\Component\News\News;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSet;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Sitemap\Component\Video\Video;
use XMLWriter;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
class UrlSetWriter
{
    /**
     * @var UrlWriter
     */
    private $urlWriter;

    /**
     * @param UrlWriter $urlWriter
     */
    public function __construct(UrlWriter $urlWriter = null)
    {
        $this->urlWriter = $urlWriter ?: new UrlWriter();
    }

    /**
     * @param XMLWriter       $xmlWriter
     * @param UrlSetInterface $urlSet
     */
    public function write(XMLWriter $xmlWriter, UrlSetInterface $urlSet)
    {
        $xmlWriter->startElement('urlset');

        $this->writeNamespaceAttributes($xmlWriter);
        $this->writeUrls($xmlWriter, $urlSet->getUrls());

        $xmlWriter->endElement();
    }

    /**
     * @param XMLWriter $xmlWriter
     */
    private function writeNamespaceAttributes(XMLWriter $xmlWriter)
    {
        $xmlWriter->writeAttribute(UrlSet::XML_NAMESPACE_ATTRIBUTE, UrlSet::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(Image::XML_NAMESPACE_ATTRIBUTE, Image::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(News::XML_NAMESPACE_ATTRIBUTE, News::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(Video::XML_NAMESPACE_ATTRIBUTE, Video::XML_NAMESPACE_URI);
    }

    /**
     * @param XMLWriter      $xmlWriter
     * @param UrlInterface[] $urls
     */
    private function writeUrls(XMLWriter $xmlWriter, array $urls)
    {
        foreach ($urls as $url) {
            $this->urlWriter->write($xmlWriter, $url);
        }
    }
}
