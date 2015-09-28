<?php

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
