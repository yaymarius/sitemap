<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\News;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\News\News;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class NewsTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testConstants()
    {
        $this->assertSame('xmlns:news', News::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.google.com/schemas/sitemap-news/0.9', News::XML_NAMESPACE_URI);

        $this->assertSame('Registration', News::ACCESS_REGISTRATION);
        $this->assertSame('Subscription', News::ACCESS_SUBSCRIPTION);

        $this->assertSame('Satire', News::GENRE_SATIRE);
        $this->assertSame('Blog', News::GENRE_BLOG);
        $this->assertSame('OpEd', News::GENRE_OP_ED);
        $this->assertSame('Opinion', News::GENRE_OPINION);
        $this->assertSame('UserGenerated', News::GENRE_USER_GENERATED);

        $this->assertSame(5, News::STOCK_TICKERS_MAX_COUNT);
    }

    public function testImplementsInterface()
    {
        $faker = $this->getFaker();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence
        );

        $this->assertInstanceOf(NewsInterface::class, $news);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence();
        $access = $faker->randomElement([
            News::ACCESS_REGISTRATION,
            News::ACCESS_SUBSCRIPTION,
        ]);
        $genres = $faker->randomElements([
            News::GENRE_BLOG,
            News::GENRE_OP_ED,
            News::GENRE_OPINION,
            News::GENRE_SATIRE,
            News::GENRE_USER_GENERATED,
        ]);
        $keywords = $faker->words;
        $stockTickers = $faker->words(News::STOCK_TICKERS_MAX_COUNT);

        $news = new News(
            $publication,
            $publicationDate,
            $title,
            $access,
            $genres,
            $keywords,
            $stockTickers
        );

        $this->assertSame($publication, $news->getPublication());
        $this->assertEquals($publicationDate, $news->getPublicationDate());
        $this->assertNotSame($publicationDate, $news->getPublicationDate());
        $this->assertSame($title, $news->getTitle());
        $this->assertSame($access, $news->getAccess());
        $this->assertSame($genres, $news->getGenres());
        $this->assertSame($keywords, $news->getKeywords());
        $this->assertSame($stockTickers, $news->getStockTickers());
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence()
        );

        $this->assertNull($news->getAccess());

        $this->assertInternalType('array', $news->getGenres());
        $this->assertCount(0, $news->getGenres());

        $this->assertInternalType('array', $news->getKeywords());
        $this->assertCount(0, $news->getKeywords());

        $this->assertInternalType('array', $news->getStockTickers());
        $this->assertCount(0, $news->getStockTickers());
    }

    /**
     * @dataProvider providerCanInjectAccess
     *
     * @param mixed $access
     */
    public function testCanInjectAccess($access)
    {
        $faker = $this->getFaker();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            $access
        );

        $this->assertSame($access, $news->getAccess());
    }

    /**
     * @return \Generator
     */
    public function providerCanInjectAccess()
    {
        $allowedValues = [
            null,
            News::ACCESS_REGISTRATION,
            News::ACCESS_SUBSCRIPTION,
        ];

        foreach ($allowedValues as $access) {
            yield [
                $access,
            ];
        }
    }

    public function testInvalidAccessIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            'foobarbaz'
        );
    }

    /**
     * @dataProvider providerCanInjectGenres
     *
     * @param mixed $genres
     */
    public function testCanInjectGenres($genres)
    {
        $faker = $this->getFaker();

        $news = new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            $faker->randomElement([
                News::ACCESS_REGISTRATION,
                News::ACCESS_SUBSCRIPTION,
            ]),
            $genres
        );

        $this->assertSame($genres, $news->getGenres());
    }

    /**
     * @return \Generator
     */
    public function providerCanInjectGenres()
    {
        $allowedValues = [
            News::GENRE_BLOG,
            News::GENRE_OP_ED,
            News::GENRE_OPINION,
            News::GENRE_SATIRE,
            News::GENRE_USER_GENERATED,
        ];

        $faker = $this->getFaker();

        for ($i = 0; $i < count($allowedValues); ++$i) {
            yield [
                $faker->randomElements($allowedValues, $i),
            ];
        }
    }

    public function testInvalidGenresAreRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $genres = [
            'foobarbaz',
        ];

        new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            $faker->randomElement([
                News::ACCESS_REGISTRATION,
                News::ACCESS_SUBSCRIPTION,
            ]),
            $genres
        );
    }

    public function testCanNotInjectMoreThanMaximumNumberOfStockTickers()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $stockTickers = $faker->words(News::STOCK_TICKERS_MAX_COUNT + 1);

        new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            $faker->randomElement([
                News::ACCESS_REGISTRATION,
                News::ACCESS_SUBSCRIPTION,
            ]),
            $faker->randomElements([
                News::GENRE_BLOG,
                News::GENRE_OP_ED,
                News::GENRE_OPINION,
                News::GENRE_SATIRE,
                News::GENRE_USER_GENERATED,
            ]),
            $faker->words,
            $stockTickers
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PublicationInterface
     */
    private function getPublicationMock()
    {
        return $this->getMockBuilder(PublicationInterface::class)->getMock();
    }
}
