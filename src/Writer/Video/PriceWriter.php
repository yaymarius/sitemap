<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PriceInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class PriceWriter
{
    public function write(PriceInterface $price, XMLWriter $xmlWriter)
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
