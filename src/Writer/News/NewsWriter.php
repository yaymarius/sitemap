<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\News;

use Refinery29\Sitemap\Component\News\NewsInterface;

/**
 * @link https://support.google.com/news/publisher/answer/74288?hl=en#exampleentry
 */
class NewsWriter
{
    /**
     * @var PublicationWriter
     */
    private $publicationWriter;

    public function __construct(PublicationWriter $publicationWriter = null)
    {
        $this->publicationWriter = $publicationWriter ?: new PublicationWriter();
    }

    public function write(NewsInterface $news, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('news:news');

        $this->publicationWriter->write($news->publication(), $xmlWriter);

        $this->writePublicationDate($xmlWriter, $news->publicationDate());
        $this->writeTitle($xmlWriter, $news->title());
        $this->writeAccess($xmlWriter, $news->access());
        $this->writeGenres($xmlWriter, $news->genres());
        $this->writeKeywords($xmlWriter, $news->keywords());
        $this->writeStockTickers($xmlWriter, $news->stockTickers());

        $xmlWriter->endElement();
    }

    private function writePublicationDate(\XMLWriter $xmlWriter, \DateTimeInterface $publicationDate)
    {
        $xmlWriter->startElement('news:publication_date');
        $xmlWriter->text($publicationDate->format('c'));
        $xmlWriter->endElement();
    }

    private function writeTitle(\XMLWriter $xmlWriter, $title)
    {
        $xmlWriter->startElement('news:title');
        $xmlWriter->text($title);
        $xmlWriter->endElement();
    }

    private function writeAccess(\XMLWriter $xmlWriter, $access = null)
    {
        if ($access === null) {
            return;
        }

        $xmlWriter->startElement('news:access');
        $xmlWriter->text($access);
        $xmlWriter->endElement();
    }

    private function writeGenres(\XMLWriter $xmlWriter, array $genres)
    {
        if (count($genres) === 0) {
            return;
        }

        $xmlWriter->startElement('news:genres');
        $xmlWriter->text(implode(', ', $genres));
        $xmlWriter->endElement();
    }

    private function writeKeywords(\XMLWriter $xmlWriter, array $keywords)
    {
        if (count($keywords) === 0) {
            return;
        }

        $xmlWriter->startElement('news:keywords');
        $xmlWriter->text(implode(', ', $keywords));
        $xmlWriter->endElement();
    }

    private function writeStockTickers(\XMLWriter $xmlWriter, array $stockTickers)
    {
        if (count($stockTickers) === 0) {
            return;
        }

        $xmlWriter->startElement('news:stock_tickers');
        $xmlWriter->text(implode(', ', $stockTickers));
        $xmlWriter->endElement();
    }
}
