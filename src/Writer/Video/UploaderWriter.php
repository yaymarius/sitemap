<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\UploaderInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class UploaderWriter
{
    public function write(UploaderInterface $uploader, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:uploader');

        if ($uploader->info() !== null) {
            $xmlWriter->writeAttribute('info', $uploader->info());
        }

        $xmlWriter->text($uploader->name());

        $xmlWriter->endElement();
    }
}
