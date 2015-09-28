<?php

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PriceInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class PriceWriter
{
    /**
     * @param XMLWriter      $xmlWriter
     * @param PriceInterface $price
     */
    public function write(XMLWriter $xmlWriter, PriceInterface $price)
    {
        $xmlWriter->startElement('video:price');
        $xmlWriter->writeAttribute('currency', $price->getCurrency());

        if ($price->getType()) {
            $xmlWriter->writeAttribute('type', $price->getType());
        }

        if ($price->getResolution()) {
            $xmlWriter->writeAttribute('resolution', $price->getResolution());
        }

        $xmlWriter->text(number_format($price->getValue(), 2));
        $xmlWriter->endElement();
    }
}
