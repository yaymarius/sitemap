<?php

namespace Refinery29\Sitemap\Test\Writer\News;

use DateTime;
use Refinery29\Sitemap\Component\News\News;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\News\NewsWriter;
use Refinery29\Sitemap\Writer\News\PublicationWriter;
use XMLWriter;

class NewsWriterTest extends AbstractTestCase
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
                $this->identicalTo($xmlWriter),
                $this->identicalTo($publication)
            )
        ;

        $writer = new NewsWriter($publicationWriter);

        $writer->write($xmlWriter, $news);
    }

    public function testWriteAdvancedNews()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence;
        $access = News::ACCESS_SUBSCRIPTION;
        $genres = $faker->randomElements([
            News::GENRE_SATIRE,
            News::GENRE_OPINION,
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
                $this->identicalTo($xmlWriter),
                $this->identicalTo($publication)
            )
        ;

        $writer = new NewsWriter($publicationWriter);

        $writer->write($xmlWriter, $news);
    }

    /**
     * @param PublicationInterface $publication
     * @param DateTime             $publicationDate
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
        DateTime $publicationDate,
        $title,
        $access = null,
        array $genres = [],
        array $keywords = [],
        array $stockTickers = []
    ) {
        $news = $this->getMockBuilder(NewsInterface::class)->getMock();

        $news
            ->expects($this->any())
            ->method('getPublication')
            ->willReturn($publication)
        ;

        $news
            ->expects($this->any())
            ->method('getPublicationDate')
            ->willReturn($publicationDate)
        ;

        $news
            ->expects($this->any())
            ->method('getTitle')
            ->willReturn($title)
        ;

        $news
            ->expects($this->any())
            ->method('getAccess')
            ->willReturn($access)
        ;

        $news
            ->expects($this->any())
            ->method('getGenres')
            ->willReturn($genres)
        ;

        $news
            ->expects($this->any())
            ->method('getKeywords')
            ->willReturn($keywords)
        ;

        $news
            ->expects($this->any())
            ->method('getStockTickers')
            ->willReturn($stockTickers)
        ;

        return $news;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationInterface
     */
    private function getPublicationMock()
    {
        return $this->getMockBuilder(PublicationInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationWriter
     */
    private function getPublicationWriterMock()
    {
        return $this->getMockBuilder(PublicationWriter::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
