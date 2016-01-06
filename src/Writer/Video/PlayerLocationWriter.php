<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class PlayerLocationWriter
{
    /**
     * @param XMLWriter               $xmlWriter
     * @param PlayerLocationInterface $playerLocation
     */
    public function write(XMLWriter $xmlWriter, PlayerLocationInterface $playerLocation)
    {
        $xmlWriter->startElement('video:player_loc');

        if ($playerLocation->getAllowEmbed()) {
            $xmlWriter->writeAttribute('allow_embed', $playerLocation->getAllowEmbed());
        }

        if ($playerLocation->getAutoPlay()) {
            $xmlWriter->writeAttribute('autoplay', $playerLocation->getAutoPlay());
        }

        $xmlWriter->text($playerLocation->getLocation());
        $xmlWriter->endElement();
    }
}
