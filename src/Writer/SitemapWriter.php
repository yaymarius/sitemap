<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\SitemapInterface;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 *
 * @internal
 */
class SitemapWriter
{
    public function write(SitemapInterface $sitemap, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('sitemap');

        $this->writeLocation($xmlWriter, $sitemap->location());
        $this->writeLastModified($xmlWriter, $sitemap->lastModified());

        $xmlWriter->endElement();
    }

    private function writeLocation(\XMLWriter $xmlWriter, $location)
    {
        $xmlWriter->startElement('loc');
        $xmlWriter->text($location);
        $xmlWriter->endElement();
    }

    private function writeLastModified(\XMLWriter $xmlWriter, \DateTimeInterface $lastModified = null)
    {
        if ($lastModified === null) {
            return;
        }

        $xmlWriter->startElement('lastmod');
        $xmlWriter->text($lastModified->format('c'));
        $xmlWriter->endElement();
    }
}
