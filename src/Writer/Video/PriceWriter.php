<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PriceInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class PriceWriter
{
    public function write(PriceInterface $price, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:price');
        $xmlWriter->writeAttribute('currency', $price->currency());

        if ($price->type()) {
            $xmlWriter->writeAttribute('type', $price->type());
        }

        if ($price->resolution()) {
            $xmlWriter->writeAttribute('resolution', $price->resolution());
        }

        $xmlWriter->text(number_format($price->value(), 2));
        $xmlWriter->endElement();
    }
}
