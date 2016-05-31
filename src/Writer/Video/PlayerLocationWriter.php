<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 *
 * @internal
 */
class PlayerLocationWriter
{
    public function write(PlayerLocationInterface $playerLocation, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('video:player_loc');

        if ($playerLocation->allowEmbed()) {
            $xmlWriter->writeAttribute('allow_embed', $playerLocation->allowEmbed());
        }

        if ($playerLocation->autoPlay()) {
            $xmlWriter->writeAttribute('autoplay', $playerLocation->autoPlay());
        }

        $xmlWriter->text($playerLocation->location());
        $xmlWriter->endElement();
    }
}
