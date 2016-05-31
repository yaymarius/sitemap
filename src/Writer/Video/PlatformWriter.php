<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PlatformInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class PlatformWriter
{
    public function write(PlatformInterface $platform, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:platform');
        $xmlWriter->writeAttribute('relationship', $platform->relationship());
        $xmlWriter->text(implode(' ', $platform->types()));
        $xmlWriter->endElement();
    }
}
