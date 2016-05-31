<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\SitemapIndexInterface;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 */
class SitemapIndexWriter
{
    /**
     * @var SitemapWriter
     */
    private $sitemapWriter;

    public function __construct(SitemapWriter $sitemapWriter = null)
    {
        $this->sitemapWriter = $sitemapWriter ?: new SitemapWriter();
    }

    /**
     * @param SitemapIndexInterface $sitemapIndex
     * @param \XMLWriter            $xmlWriter
     *
     * @return string
     */
    public function write(SitemapIndexInterface $sitemapIndex, \XMLWriter $xmlWriter = null)
    {
        $xmlWriter = $xmlWriter ?: new \XMLWriter();

        $xmlWriter->openMemory();
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('sitemapindex');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($sitemapIndex->sitemaps() as $sitemap) {
            $this->sitemapWriter->write($sitemap, $xmlWriter);
        }

        $xmlWriter->endElement();

        $xmlWriter->endDocument();

        return $xmlWriter->outputMemory();
    }
}
