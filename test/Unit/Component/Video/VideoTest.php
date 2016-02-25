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

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $thumbnailLocation = $faker->url;
        $title = $faker->sentence;
        $description = $faker->paragraphs(5, true);
        $contentLocation = $faker->url;
        $playerLocation = $this->getPlayerLocationMock();
        $galleryLocation = $this->getGalleryLocationMock();
        $duration = $faker->numberBetween(
            VideoInterface::DURATION_LOWER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT
        );
        $publicationDate = $faker->dateTime;
        $expirationDate = $faker->dateTime;
        $rating = $faker->randomFloat(1, 0, 5);
        $viewCount = $faker->randomNumber();
        $familyFriendly = VideoInterface::FAMILY_FRIENDLY_NO;
        $category = $faker->word;
        $restriction = $this->getRestrictionMock();
        $requiresSubscription = $faker->randomElement([
            VideoInterface::REQUIRES_SUBSCRIPTION_YES,
            VideoInterface::REQUIRES_SUBSCRIPTION_NO,
        ]);
        $uploader = $this->getUploaderMock();
        $platform = $this->getPlatformMock();
        $live = $faker->randomElement([
            VideoInterface::LIVE_NO,
            VideoInterface::LIVE_YES,
        ]);

        $video = new Video(
            $thumbnailLocation,
            $title,
            $description,
            $contentLocation,
            $playerLocation,
            $galleryLocation,
            $duration,
            $publicationDate,
            $expirationDate,
            $rating,
            $viewCount,
            $familyFriendly,
            $category,
            $restriction,
            $requiresSubscription,
            $uploader,
            $platform,
            $live
        );

        $this->assertSame($thumbnailLocation, $video->thumbnailLocation());
        $this->assertSame($title, $video->title());
        $this->assertSame($description, $video->description());
        $this->assertSame($contentLocation, $video->contentLocation());
        $this->assertSame($playerLocation, $video->playerLocation());
        $this->assertSame($galleryLocation, $video->galleryLocation());
        $this->assertSame($duration, $video->duration());
        $this->assertEquals($publicationDate, $video->publicationDate());
        $this->assertNotSame($publicationDate, $video->publicationDate());
        $this->assertEquals($expirationDate, $video->expirationDate());
        $this->assertNotSame($expirationDate, $video->expirationDate());
        $this->assertSame($rating, $video->rating());
        $this->assertSame($viewCount, $video->viewCount());
        $this->assertSame($familyFriendly, $video->familyFriendly());
        $this->assertSame($category, $video->category());
        $this->assertSame($restriction, $video->restriction());
        $this->assertSame($requiresSubscription, $video->requiresSubscription());
        $this->assertSame($uploader, $video->uploader());
        $this->assertSame($platform, $video->platform());
        $this->assertSame($live, $video->live());
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

    public function testTitleLongerThanMaxLengthIsRejected()
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

    public function testDescriptionLongerThanMaxLengthIsRejected()
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

    public function testContentAndPlayerLocationCanNotBothBeNull()
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

    /**
     * @dataProvider providerInvalidDurationIsRejected
     *
     * @param mixed $duration
     */
    public function testInvalidDurationIsRejected($duration)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $duration
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidDurationIsRejected()
    {
        $invalidValues = [
            'foo',
            VideoInterface::DURATION_LOWER_LIMIT - 1,
            VideoInterface::DURATION_LOWER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT + 1,
        ];

        foreach ($invalidValues as $duration) {
            yield [
                $duration,
            ];
        }
    }

    /**
     * @dataProvider providerInvalidRatingIsRejected
     *
     * @param mixed $rating
     */
    public function testInvalidRatingIsRejected($rating)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $rating
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidRatingIsRejected()
    {
        $invalidValues = [
            'foo',
            VideoInterface::RATING_MIN - 0.1,
            VideoInterface::RATING_MAX + 0.1,
        ];

        foreach ($invalidValues as $rating) {
            yield [
                $rating,
            ];
        }
    }

    /**
     * @dataProvider providerInvalidViewCountIsRejected
     *
     * @param mixed $viewCount
     */
    public function testInvalidViewCountIsRejected($viewCount)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $viewCount
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidViewCountIsRejected()
    {
        $invalidValues = [
            'foo',
            -1,
        ];

        foreach ($invalidValues as $viewCount) {
            yield [
                $viewCount,
            ];
        }
    }

    /**
     * @dataProvider providerInvalidFamilyFriendlyIsRejected
     *
     * @param mixed $familyFriendly
     */
    public function testInvalidFamilyFriendlyIsRejected($familyFriendly)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            $familyFriendly
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidFamilyFriendlyIsRejected()
    {
        $invalidValues = [
            'foo',
            true,
        ];

        foreach ($invalidValues as $familyFriendly) {
            yield [
                $familyFriendly,
            ];
        }
    }

    /**
     * @dataProvider providerInvalidRequiresSubscriptionIsRejected
     *
     * @param mixed $requiresSubscription
     */
    public function testInvalidRequiresSubscriptionIsRejected($requiresSubscription)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            VideoInterface::FAMILY_FRIENDLY_NO,
            $faker->word,
            $this->getRestrictionMock(),
            $requiresSubscription
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidRequiresSubscriptionIsRejected()
    {
        $invalidValues = [
            'foobarbaz',
            true,
        ];

        foreach ($invalidValues as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testCanAddTag()
    {
        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        $tag = $this->getTagMock();

        $video->addTag($tag);

        $this->assertInternalType('array', $video->tags());
        $this->assertCount(1, $video->tags());
        $this->assertSame($tag, $video->tags()[0]);
    }

    public function testCanNotAddMoreThanMaximumNumberOfTags()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        for ($i = 0; $i < VideoInterface::TAG_MAX_COUNT; ++$i) {
            $video->addTag($this->getTagMock());
        }

        $video->addTag($this->getTagMock());
    }

    public function testCategoryLongerThanMaxLengthIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $category = str_repeat('a', VideoInterface::CATEGORY_MAX_LENGTH + 1);

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            VideoInterface::FAMILY_FRIENDLY_NO,
            $category
        );
    }

    public function testCanAddPrice()
    {
        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        $price = $this->getPriceMock();

        $video->addPrice($price);

        $this->assertInternalType('array', $video->prices());
        $this->assertCount(1, $video->prices());
        $this->assertSame($price, $video->prices()[0]);
    }

    /**
     * @dataProvider providerInvalidLiveIsRejected
     *
     * @param mixed $live
     */
    public function testInvalidLiveIsRejected($live)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                VideoInterface::DURATION_LOWER_LIMIT,
                VideoInterface::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            VideoInterface::FAMILY_FRIENDLY_NO,
            $faker->word,
            $this->getRestrictionMock(),
            $faker->randomElement([
                VideoInterface::REQUIRES_SUBSCRIPTION_YES,
                VideoInterface::REQUIRES_SUBSCRIPTION_NO,
            ]),
            $this->getUploaderMock(),
            $this->getPlatformMock(),
            $live
        );
    }

    /**
     * @return \Generator
     */
    public function providerInvalidLiveIsRejected()
    {
        $invalidValues = [
            'foobarbaz',
            true,
        ];

        foreach ($invalidValues as $value) {
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
