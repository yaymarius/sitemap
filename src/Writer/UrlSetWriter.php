<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
class UrlSetWriter
{
    /**
     * @var UrlWriter
     */
    private $urlWriter;

    public function __construct(UrlWriter $urlWriter = null)
    {
        $this->urlWriter = $urlWriter ?: new UrlWriter();
    }

    /**
     * @param UrlSetInterface $urlSet
     * @param \XMLWriter      $xmlWriter
     *
     * @return string
     */
    public function write(UrlSetInterface $urlSet, \XMLWriter $xmlWriter = null)
    {
        $xmlWriter = $xmlWriter ?: new \XMLWriter();

        $xmlWriter->openMemory();
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('urlset');

        $this->writeNamespaceAttributes($xmlWriter);
        $this->writeUrls($xmlWriter, $urlSet->urls());

        $xmlWriter->endElement();

        $xmlWriter->endDocument();

        return $xmlWriter->outputMemory();
    }

    private function writeNamespaceAttributes(\XMLWriter $xmlWriter)
    {
        $xmlWriter->writeAttribute(UrlSetInterface::XML_NAMESPACE_ATTRIBUTE, UrlSetInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(ImageInterface::XML_NAMESPACE_ATTRIBUTE, ImageInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(NewsInterface::XML_NAMESPACE_ATTRIBUTE, NewsInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(VideoInterface::XML_NAMESPACE_ATTRIBUTE, VideoInterface::XML_NAMESPACE_URI);
    }

    /**
     * @param \XMLWriter     $xmlWriter
     * @param UrlInterface[] $urls
     */
    private function writeUrls(\XMLWriter $xmlWriter, array $urls)
    {
        foreach ($urls as $url) {
            $this->urlWriter->write($url, $xmlWriter);
        }
    }
}
