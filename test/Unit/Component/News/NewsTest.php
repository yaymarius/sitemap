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

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $publication = $this->getPublicationMock();
        $publicationDate = $faker->dateTime;
        $title = $faker->sentence();
        $access = $faker->randomElement([
            NewsInterface::ACCESS_REGISTRATION,
            NewsInterface::ACCESS_SUBSCRIPTION,
        ]);
        $genres = $faker->randomElements([
            NewsInterface::GENRE_BLOG,
            NewsInterface::GENRE_OP_ED,
            NewsInterface::GENRE_OPINION,
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_USER_GENERATED,
        ]);
        $keywords = $faker->words;
        $stockTickers = $faker->words(NewsInterface::STOCK_TICKERS_MAX_COUNT);

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
            NewsInterface::ACCESS_REGISTRATION,
            NewsInterface::ACCESS_SUBSCRIPTION,
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
                NewsInterface::ACCESS_REGISTRATION,
                NewsInterface::ACCESS_SUBSCRIPTION,
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
            NewsInterface::GENRE_BLOG,
            NewsInterface::GENRE_OP_ED,
            NewsInterface::GENRE_OPINION,
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_USER_GENERATED,
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
                NewsInterface::ACCESS_REGISTRATION,
                NewsInterface::ACCESS_SUBSCRIPTION,
            ]),
            $genres
        );
    }

    public function testCanNotInjectMoreThanMaximumNumberOfStockTickers()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $stockTickers = $faker->words(NewsInterface::STOCK_TICKERS_MAX_COUNT + 1);

        new News(
            $this->getPublicationMock(),
            $faker->dateTime,
            $faker->sentence(),
            $faker->randomElement([
                NewsInterface::ACCESS_REGISTRATION,
                NewsInterface::ACCESS_SUBSCRIPTION,
            ]),
            $faker->randomElements([
                NewsInterface::GENRE_BLOG,
                NewsInterface::GENRE_OP_ED,
                NewsInterface::GENRE_OPINION,
                NewsInterface::GENRE_SATIRE,
                NewsInterface::GENRE_USER_GENERATED,
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
