<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\RestrictionInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class RestrictionWriter
{
    public function write(RestrictionInterface $restriction, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:restriction');
        $xmlWriter->writeAttribute('relationship', $restriction->relationship());
        $xmlWriter->text(implode(' ', $restriction->countryCodes()));
        $xmlWriter->endElement();
    }
}
