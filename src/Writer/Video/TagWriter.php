<?php

namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\TagInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class TagWriter
{
    /**
     * @param XMLWriter    $xmlWriter
     * @param TagInterface $tag
     */
    public function write(XMLWriter $xmlWriter, TagInterface $tag)
    {
        $xmlWriter->startElement('video:tag');
        $xmlWriter->text($tag->getContent());
        $xmlWriter->endElement();
    }
}
