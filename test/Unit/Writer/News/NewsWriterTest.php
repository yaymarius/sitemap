<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer\News;

use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\News\NewsWriter;
use Refinery29\Sitemap\Writer\News\PublicationWriter;

final class NewsWriterTest extends AbstractTestCase
{
    public function testConstructorCreatesRequiredWriter()
    {
        $writer = new NewsWriter();

        $this->assertAttributeInstanceOf(PublicationWriter::class, 'publicationWriter', $writer);
    }

    public function testWriteSimpleNews()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence;
        $news = $this->getNewsMock(
            $publication,
            $publicationDate,
            $title
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'news:news');

        $this->expectToWriteElement($xmlWriter, 'news:publication_date', $publicationDate->format('c'));
        $this->expectToWriteElement($xmlWriter, 'news:title', $title);

        $this->expectToEndElement($xmlWriter);

        $publicationWriter = $this->getPublicationWriterMock();

        $publicationWriter
            ->expects($this->once())
            ->method('write')
            ->with(
                $this->identicalTo($publication),
                $this->identicalTo($xmlWriter)
            );

        $writer = new NewsWriter($publicationWriter);

        $writer->write($news, $xmlWriter);
    }

    public function testWriteAdvancedNews()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence;
        $access = NewsInterface::ACCESS_SUBSCRIPTION;
        $genres = $faker->randomElements([
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_OPINION,
        ]);
        $keywords = $faker->words;
        $stockTickers = $faker->words;
        $news = $this->getNewsMock(
            $publication,
            $publicationDate,
            $title,
            $access,
            $genres,
            $keywords,
            $stockTickers
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'news:news');

        $this->expectToWriteElement($xmlWriter, 'news:publication_date', $publicationDate->format('c'));
        $this->expectToWriteElement($xmlWriter, 'news:title', $title);
        $this->expectToWriteElement($xmlWriter, 'news:access', $access);
        $this->expectToWriteElement($xmlWriter, 'news:genres', implode(', ', $genres));
        $this->expectToWriteElement($xmlWriter, 'news:keywords', implode(', ', $keywords));
        $this->expectToWriteElement($xmlWriter, 'news:stock_tickers', implode(', ', $stockTickers));

        $this->expectToEndElement($xmlWriter);

        $publicationWriter = $this->getPublicationWriterMock();

        $publicationWriter
            ->expects($this->once())
            ->method('write')
            ->with(
                $this->identicalTo($publication),
                $this->identicalTo($xmlWriter)
            );

        $writer = new NewsWriter($publicationWriter);

        $writer->write($news, $xmlWriter);
    }

    /**
     * @param PublicationInterface $publication
     * @param \DateTime            $publicationDate
     * @param string               $title
     * @param string               $access
     * @param array                $genres
     * @param array                $keywords
     * @param array                $stockTickers
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|NewsInterface
     */
    private function getNewsMock(
        PublicationInterface $publication,
        \DateTime $publicationDate,
        $title,
        $access = null,
        array $genres = [],
        array $keywords = [],
        array $stockTickers = []
    ) {
        $news = $this->createMock(NewsInterface::class);

        $news
            ->expects($this->any())
            ->method('publication')
            ->willReturn($publication);

        $news
            ->expects($this->any())
            ->method('publicationDate')
            ->willReturn($publicationDate);

        $news
            ->expects($this->any())
            ->method('title')
            ->willReturn($title);

        $news
            ->expects($this->any())
            ->method('access')
            ->willReturn($access);

        $news
            ->expects($this->any())
            ->method('genres')
            ->willReturn($genres);

        $news
            ->expects($this->any())
            ->method('keywords')
            ->willReturn($keywords);

        $news
            ->expects($this->any())
            ->method('stockTickers')
            ->willReturn($stockTickers);

        return $news;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationInterface
     */
    private function getPublicationMock()
    {
        return $this->createMock(PublicationInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationWriter
     */
    private function getPublicationWriterMock()
    {
        return $this->createMock(PublicationWriter::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->createMock(\XMLWriter::class);
    }
}
