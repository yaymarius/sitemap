<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\News;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\News\News;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class NewsTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(News::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsNewsInterface()
    {
        $reflectionClass = new ReflectionClass(News::class);

        $this->assertTrue($reflectionClass->implementsInterface(NewsInterface::class));
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $this->assertNull($news->access());

        $this->assertInternalType('array', $news->genres());
        $this->assertCount(0, $news->genres());

        $this->assertInternalType('array', $news->keywords());
        $this->assertCount(0, $news->keywords());

        $this->assertInternalType('array', $news->stockTickers());
        $this->assertCount(0, $news->stockTickers());
    }

    /**
     * @dataProvider Refinery29\Sitemap\Test\Util\DataProvider\InvalidString::data
     *
     * @param mixed $title
     */
    public function testConstructorRejectsInvalidTitle($title)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $title
        );
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence();

        $news = new News(
            $publication,
            $publicationDate,
            $title
        );

        $this->assertSame($publication, $news->publication());
        $this->assertNotSame($publicationDate, $news->publicationDate());
        $this->assertSame($title, $news->title());
    }

    public function testWithAccessRejectsInvalidValue()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $access = $faker->sentence();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $news->withAccess($access);
    }

    public function testWithAccessClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $access = $faker->randomElement([
            NewsInterface::ACCESS_REGISTRATION,
            NewsInterface::ACCESS_SUBSCRIPTION,
        ]);

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $instance = $news->withAccess($access);

        $this->assertInstanceOf(News::class, $instance);
        $this->assertNotSame($news, $instance);
        $this->assertSame($access, $instance->access());
    }

    public function testWithGenresRejectsInvalidValues()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $genres = [
            'foobarbaz',
        ];

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $news->withGenres($genres);
    }

    public function testWithGenresClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $genres = $faker->randomElements([
            NewsInterface::GENRE_BLOG,
            NewsInterface::GENRE_OP_ED,
            NewsInterface::GENRE_OPINION,
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_USER_GENERATED,
        ]);

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $instance = $news->withGenres($genres);

        $this->assertInstanceOf(News::class, $instance);
        $this->assertNotSame($news, $instance);
        $this->assertSame($genres, $instance->genres());
    }

    /**
     * @dataProvider Refinery29\Sitemap\Test\Util\DataProvider\InvalidString::data
     *
     * @param mixed $keyword
     */
    public function testWithKeywordsRejectsInvalidValues($keyword)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $keywords = [
            $faker->word,
            $faker->word,
            $keyword,
        ];

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $news->withKeywords($keywords);
    }

    public function testWithKeywordsClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $keywords = $faker->words;

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $instance = $news->withKeywords($keywords);

        $this->assertInstanceOf(News::class, $instance);
        $this->assertNotSame($news, $instance);
        $this->assertSame($keywords, $instance->keywords());
    }

    /**
     * @dataProvider Refinery29\Sitemap\Test\Util\DataProvider\InvalidString::data
     *
     * @param mixed $stockTicker
     */
    public function testWithStockTickersRejectsInvalidValues($stockTicker)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $stockTickers = [
            $faker->word,
            $faker->word,
            $stockTicker,
        ];

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $news->withStockTickers($stockTickers);
    }

    public function testWithStockTickersRejectsTooManyValues()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $stockTickers = $faker->words(NewsInterface::STOCK_TICKERS_MAX_COUNT + 1);

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $news->withStockTickers($stockTickers);
    }

    public function testWithStockTickersClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $stockTickers = $faker->words(NewsInterface::STOCK_TICKERS_MAX_COUNT);

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $instance = $news->withStockTickers($stockTickers);

        $this->assertInstanceOf(News::class, $instance);
        $this->assertNotSame($news, $instance);
        $this->assertSame($stockTickers, $instance->stockTickers());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationInterface
     */
    private function getPublicationMock()
    {
        return $this->getMockBuilder(PublicationInterface::class)->getMock();
    }
}
