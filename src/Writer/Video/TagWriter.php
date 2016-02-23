<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Writer\Video;

use Refinery29\Sitemap\Component\Video\TagInterface;
use XMLWriter;

/**
 * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
 */
class TagWriter
{
    public function write(XMLWriter $xmlWriter, TagInterface $tag)
    {
        $xmlWriter->startElement('video:tag');
        $xmlWriter->text($tag->getContent());
        $xmlWriter->endElement();
    }
}
