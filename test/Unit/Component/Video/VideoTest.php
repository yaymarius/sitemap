<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Component\Video\Video;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;
use stdClass;

class VideoTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Video::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsVideoInterface()
    {
        $reflectionClass = new ReflectionClass(Video::class);

        $this->assertTrue($reflectionClass->implementsInterface(VideoInterface::class));
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        $this->assertNull($video->playerLocation());
        $this->assertNull($video->galleryLocation());
        $this->assertNull($video->duration());
        $this->assertNull($video->publicationDate());
        $this->assertNull($video->expirationDate());
        $this->assertNull($video->rating());
        $this->assertNull($video->viewCount());
        $this->assertNull($video->familyFriendly());
        $this->assertInternalType('array', $video->tags());
        $this->assertCount(0, $video->tags());
        $this->assertNull($video->category());
        $this->assertNull($video->restriction());
        $this->assertInternalType('array', $video->prices());
        $this->assertCount(0, $video->prices());
        $this->assertNull($video->requiresSubscription());
        $this->assertNull($video->uploader());
        $this->assertNull($video->platform());
    }

    public function testConstructorRejectsTitleLongerThanMaxLength()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $title = str_repeat('a', VideoInterface::TITLE_MAX_LENGTH + 1);

        new Video(
            $faker->url,
            $title,
            $faker->paragraphs(5, true),
            $faker->url
        );
    }

    public function testConstructorRejectsDescriptionLongerThanMaxLength()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $description = str_repeat('a', VideoInterface::DESCRIPTION_MAX_LENGTH + 1);

        new Video(
            $faker->url,
            $faker->sentence,
            $description,
            $faker->url
        );
    }

    public function testConstructorRejectsInvalidCombinationOfContentAndPlayerLocation()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->unique()->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            null,
            null
        );
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $thumbnailLocation = $faker->url;
        $title = $faker->sentence;
        $description = $faker->paragraphs(5, true);
        $contentLocation = $faker->url;
        $playerLocation = $this->getPlayerLocationMock();

        $video = new Video(
            $thumbnailLocation,
            $title,
            $description,
            $contentLocation,
            $playerLocation
        );

        $this->assertSame($thumbnailLocation, $video->thumbnailLocation());
        $this->assertSame($title, $video->title());
        $this->assertSame($description, $video->description());
        $this->assertSame($contentLocation, $video->contentLocation());
        $this->assertSame($playerLocation, $video->playerLocation());
    }

    public function testWithGalleryLocationClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $galleryLocation = $this->getGalleryLocationMock();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withGalleryLocation($galleryLocation);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($galleryLocation, $instance->galleryLocation());
    }

    /**
     * @dataProvider providerInvalidDuration
     *
     * @param mixed $duration
     */
    public function testWithDurationRejectsInvalidDuration($duration)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withDuration($duration);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidDuration()
    {
        $values = [
            'foo',
            VideoInterface::DURATION_LOWER_LIMIT - 1,
            VideoInterface::DURATION_LOWER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT + 1,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithDurationClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $duration = $faker->numberBetween(
            VideoInterface::DURATION_LOWER_LIMIT + 1,
            VideoInterface::DURATION_UPPER_LIMIT - 1
        );

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withDuration($duration);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($duration, $instance->duration());
    }

    public function testWithPublicationDateClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $publicationDate = $faker->dateTime;

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withPublicationDate($publicationDate);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertEquals($publicationDate, $instance->publicationDate());
        $this->assertNotSame($publicationDate, $instance->publicationDate());
    }

    public function testWithExpirationDateClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $expirationDate = $faker->dateTime;

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withExpirationDate($expirationDate);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertEquals($expirationDate, $instance->expirationDate());
        $this->assertNotSame($expirationDate, $instance->expirationDate());
    }

    /**
     * @dataProvider providerInvalidRating
     *
     * @param mixed $rating
     */
    public function testWithRatingRejectsInvalidValue($rating)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withRating($rating);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidRating()
    {
        $values = [
            'foo',
            VideoInterface::RATING_MIN - 0.1,
            VideoInterface::RATING_MAX + 0.1,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithRatingClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $rating = $faker->randomFloat(
            2,
            VideoInterface::RATING_MIN,
            VideoInterface::RATING_MAX
        );

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withRating($rating);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($rating, $instance->rating());
    }

    /**
     * @dataProvider providerInvalidViewCount
     *
     * @param mixed $viewCount
     */
    public function testWithViewCountRejectsInvalidValue($viewCount)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withViewCount($viewCount);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidViewCount()
    {
        $values = [
            'foo',
            -1,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithViewCountClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $viewCount = $faker->numberBetween(0);

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withViewCount($viewCount);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($viewCount, $instance->viewCount());
    }

    /**
     * @dataProvider providerInvalidFamilyFriendly
     *
     * @param mixed $familyFriendly
     */
    public function testWithFamilyFriendlyRejectsInvalidValue($familyFriendly)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withFamilyFriendly($familyFriendly);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidFamilyFriendly()
    {
        $values = [
            'foo',
            true,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithFamilyFriendlyClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $familyFriendly = VideoInterface::FAMILY_FRIENDLY_NO;

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withFamilyFriendly($familyFriendly);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($familyFriendly, $instance->familyFriendly());
    }

    /**
     * @dataProvider providerInvalidTags
     *
     * @param mixed $tags
     */
    public function testWithTagsRejectsInvalidValue($tags)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withTags($tags);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidTags()
    {
        $faker = $this->getFaker();

        $values = [
            $faker->words(),
            [
                $this->getTagMock(),
                $this->getTagMock(),
                new stdClass(),
            ],
            array_fill(
                0,
                VideoInterface::TAG_MAX_COUNT + 1,
                $this->getTagMock()
            ),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithTagsClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $tags = [
            $this->getTagMock(),
            $this->getTagMock(),
            $this->getTagMock(),
        ];

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withTags($tags);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($tags, $instance->tags());
    }

    /**
     * @dataProvider providerInvalidCategory
     */
    public function testWithCategoryRejectsInvalidValue($category)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withCategory($category);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidCategory()
    {
        $faker = $this->getFaker();

        $values = [
            $faker->boolean(),
            $faker->randomFloat(),
            $faker->randomNumber(),
            $faker->words(),
            str_repeat(
                'a',
                VideoInterface::CATEGORY_MAX_LENGTH + 1
            ),
            new stdClass(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithCategoryClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $category = $faker->sentence;

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withCategory($category);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($category, $instance->category());
    }

    public function testWithRestrictionClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $restriction = $this->getRestrictionMock();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withRestriction($restriction);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($restriction, $instance->restriction());
    }

    /**
     * @dataProvider providerInvalidPrices
     *
     * @param mixed $prices
     */
    public function testWithPricesRejectsInvalidValue($prices)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withPrices($prices);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidPrices()
    {
        $faker = $this->getFaker();

        $values = [
            $faker->words(),
            [
                $this->getPriceMock(),
                $this->getPriceMock(),
                new stdClass(),
            ],
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithPricesClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $prices = [
            $this->getPriceMock(),
            $this->getPriceMock(),
            $this->getPriceMock(),
        ];

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withPrices($prices);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($prices, $instance->prices());
    }

    /**
     * @dataProvider providerInvalidRequiresSubscription
     *
     * @param mixed $requiresSubscription
     */
    public function testWithRequiresSubscriptionRejectsInvalidValue($requiresSubscription)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withRequiresSubscription($requiresSubscription);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidRequiresSubscription()
    {
        $values = [
            'foobarbaz',
            true,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithRequiresSubscriptionClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $requiresSubscription = $faker->randomElement([
            VideoInterface::REQUIRES_SUBSCRIPTION_NO,
            VideoInterface::REQUIRES_SUBSCRIPTION_YES,
        ]);

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withRequiresSubscription($requiresSubscription);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($requiresSubscription, $instance->requiresSubscription());
    }

    public function testWithUploaderClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $uploader = $this->getUploaderMock();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withUploader($uploader);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($uploader, $instance->uploader());
    }

    public function testWithPlatformClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $platform = $this->getPlatformMock();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withPlatform($platform);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($platform, $instance->platform());
    }

    /**
     * @dataProvider providerInvalidLive
     *
     * @param mixed $live
     */
    public function testWithLiveRejectsInvalidValue($live)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withLive($live);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidLive()
    {
        $values = [
            'foobarbaz',
            true,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testWithLiveClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $live = $faker->randomElement([
            VideoInterface::LIVE_NO,
            VideoInterface::LIVE_YES,
        ]);

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $instance = $video->withLive($live);

        $this->assertInstanceOf(Video::class, $instance);
        $this->assertNotSame($video, $instance);
        $this->assertSame($live, $instance->live());
    }

    /**
     * @return \Generator
     */
    public function providerInvalidLiveIsRejected()
    {
        $values = [
            'foobarbaz',
            true,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|GalleryLocationInterface
     */
    private function getGalleryLocationMock()
    {
        return $this->getMockBuilder(GalleryLocationInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PlatformInterface
     */
    private function getPlatformMock()
    {
        return $this->getMockBuilder(PlatformInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PlayerLocationInterface
     */
    private function getPlayerLocationMock()
    {
        return $this->getMockBuilder(PlayerLocationInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PriceInterface
     */
    private function getPriceMock()
    {
        return $this->getMockBuilder(PriceInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RestrictionInterface
     */
    private function getRestrictionMock()
    {
        return $this->getMockBuilder(RestrictionInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TagInterface
     */
    private function getTagMock()
    {
        return $this->getMockBuilder(TagInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UploaderInterface
     */
    private function getUploaderMock()
    {
        return $this->getMockBuilder(UploaderInterface::class)->getMock();
    }
}
