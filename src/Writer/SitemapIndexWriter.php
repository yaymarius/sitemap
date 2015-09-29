<?php

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\SitemapIndexInterface;
use XMLWriter;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 */
class SitemapIndexWriter
{
    /**
     * @var SitemapWriter
     */
    private $sitemapWriter;

    /**
     * @param SitemapWriter $sitemapWriter
     */
    public function __construct(SitemapWriter $sitemapWriter = null)
    {
        $this->sitemapWriter = $sitemapWriter ?: new SitemapWriter();
    }

    /**
     * @param XMLWriter             $xmlWriter
     * @param SitemapIndexInterface $sitemapIndex
     */
    public function write(XMLWriter $xmlWriter, SitemapIndexInterface $sitemapIndex)
    {
        $xmlWriter->startElement('sitemapindex');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($sitemapIndex->getSitemaps() as $sitemap) {
            $this->sitemapWriter->write($xmlWriter, $sitemap);
        }

        $xmlWriter->endElement();
    }
}
