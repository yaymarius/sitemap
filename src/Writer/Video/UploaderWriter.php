<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\UploaderInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class UploaderWriter
{
    /**
     * @param XMLWriter         $xmlWriter
     * @param UploaderInterface $uploader
     */
    public function write(XMLWriter $xmlWriter, UploaderInterface $uploader)
    {
        $xmlWriter->startElement('video:uploader');

        if ($uploader->getInfo() !== null) {
            $xmlWriter->writeAttribute('info', $uploader->getInfo());
        }

        $xmlWriter->text($uploader->getName());

        $xmlWriter->endElement();
    }
}
