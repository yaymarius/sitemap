<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class GalleryLocationWriter
{
    public function write(GalleryLocationInterface $galleryLocation, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:gallery_loc');

        if ($galleryLocation->title()) {
            $xmlWriter->writeAttribute('title', $galleryLocation->title());
        }

        $xmlWriter->text($galleryLocation->location());
        $xmlWriter->endElement();
    }
}
