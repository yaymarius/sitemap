<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Component\Video;

use BadMethodCallException;
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
use Refinery29\Sitemap\Test\Util\FakerTrait;

class VideoTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testConstants()
    {
        $this->assertSame('xmlns:video', Video::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.google.com/schemas/sitemap-video/1.1', Video::XML_NAMESPACE_URI);

        $this->assertSame(100, Video::TITLE_MAX_LENGTH);

        $this->assertSame(0, Video::DURATION_LOWER_LIMIT);
        $this->assertSame(28800, Video::DURATION_UPPER_LIMIT);

        $this->assertSame(0.0, Video::RATING_MIN);
        $this->assertSame(5.0, Video::RATING_MAX);

        $this->assertSame('yes', Video::REQUIRES_SUBSCRIPTION_YES);
        $this->assertSame('no', Video::REQUIRES_SUBSCRIPTION_NO);

        $this->assertSame('no', Video::FAMILY_FRIENDLY_NO);

        $this->assertSame(256, Video::CATEGORY_MAX_LENGTH);

        $this->assertSame(32, Video::TAG_MAX_COUNT);
    }

    public function testImplementsInterface()
    {
        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        $this->assertInstanceOf(VideoInterface::class, $video);
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
            Video::DURATION_LOWER_LIMIT,
            Video::DURATION_UPPER_LIMIT
        );
        $publicationDate = $faker->dateTime;
        $expirationDate = $faker->dateTime;
        $rating = $faker->randomFloat(1, 0, 5);
        $viewCount = $faker->randomNumber();
        $familyFriendly = Video::FAMILY_FRIENDLY_NO;
        $category = $faker->word;
        $restriction = $this->getRestrictionMock();
        $requiresSubscription = $faker->randomElement([
            Video::REQUIRES_SUBSCRIPTION_YES,
            Video::REQUIRES_SUBSCRIPTION_NO,
        ]);
        $uploader = $this->getUploaderMock();
        $platform = $this->getPlatformMock();
        $live = $faker->randomElement([
            Video::LIVE_NO,
            Video::LIVE_YES,
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

        $this->assertSame($thumbnailLocation, $video->getThumbnailLocation());
        $this->assertSame($title, $video->getTitle());
        $this->assertSame($description, $video->getDescription());
        $this->assertSame($contentLocation, $video->getContentLocation());
        $this->assertSame($playerLocation, $video->getPlayerLocation());
        $this->assertSame($galleryLocation, $video->getGalleryLocation());
        $this->assertSame($duration, $video->getDuration());
        $this->assertEquals($publicationDate, $video->getPublicationDate());
        $this->assertNotSame($publicationDate, $video->getPublicationDate());
        $this->assertEquals($expirationDate, $video->getExpirationDate());
        $this->assertNotSame($expirationDate, $video->getExpirationDate());
        $this->assertSame($rating, $video->getRating());
        $this->assertSame($viewCount, $video->getViewCount());
        $this->assertSame($familyFriendly, $video->getFamilyFriendly());
        $this->assertSame($category, $video->getCategory());
        $this->assertSame($restriction, $video->getRestriction());
        $this->assertSame($requiresSubscription, $video->getRequiresSubscription());
        $this->assertSame($uploader, $video->getUploader());
        $this->assertSame($platform, $video->getPlatform());
        $this->assertSame($live, $video->getLive());
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

        $this->assertNull($video->getPlayerLocation());
        $this->assertNull($video->getGalleryLocation());
        $this->assertNull($video->getDuration());
        $this->assertNull($video->getPublicationDate());
        $this->assertNull($video->getExpirationDate());
        $this->assertNull($video->getRating());
        $this->assertNull($video->getViewCount());
        $this->assertNull($video->getFamilyFriendly());
        $this->assertInternalType('array', $video->getTags());
        $this->assertCount(0, $video->getTags());
        $this->assertNull($video->getCategory());
        $this->assertNull($video->getRestriction());
        $this->assertInternalType('array', $video->getPrices());
        $this->assertCount(0, $video->getPrices());
        $this->assertNull($video->getRequiresSubscription());
        $this->assertNull($video->getUploader());
        $this->assertNull($video->getPlatform());
    }

    public function testTitleLongerThanMaxLengthIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $title = str_repeat('a', Video::TITLE_MAX_LENGTH + 1);

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

        $description = str_repeat('a', Video::DESCRIPTION_MAX_LENGTH + 1);

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
            Video::DURATION_LOWER_LIMIT - 1,
            Video::DURATION_LOWER_LIMIT,
            Video::DURATION_UPPER_LIMIT,
            Video::DURATION_UPPER_LIMIT + 1,
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
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
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
            Video::RATING_MIN - 0.1,
            Video::RATING_MAX + 0.1,
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
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
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
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
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
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            Video::FAMILY_FRIENDLY_NO,
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

        $this->assertInternalType('array', $video->getTags());
        $this->assertCount(1, $video->getTags());
        $this->assertSame($tag, $video->getTags()[0]);
    }

    public function testCanNotAddMoreThanMaximumNumberOfTags()
    {
        $this->setExpectedException(BadMethodCallException::class);

        $faker = $this->getFaker();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url
        );

        for ($i = 0; $i < Video::TAG_MAX_COUNT; $i++) {
            $video->addTag($this->getTagMock());
        }

        $video->addTag($this->getTagMock());
    }

    public function testCategoryLongerThanMaxLengthIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $category = str_repeat('a', Video::CATEGORY_MAX_LENGTH + 1);

        new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock(),
            $this->getGalleryLocationMock(),
            $faker->numberBetween(
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            Video::FAMILY_FRIENDLY_NO,
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

        $this->assertInternalType('array', $video->getPrices());
        $this->assertCount(1, $video->getPrices());
        $this->assertSame($price, $video->getPrices()[0]);
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
                Video::DURATION_LOWER_LIMIT,
                Video::DURATION_UPPER_LIMIT
            ),
            $faker->dateTime,
            $faker->dateTime,
            $faker->randomFloat(1, 0, 5),
            $faker->randomNumber(),
            Video::FAMILY_FRIENDLY_NO,
            $faker->word,
            $this->getRestrictionMock(),
            $faker->randomElement([
                Video::REQUIRES_SUBSCRIPTION_YES,
                Video::REQUIRES_SUBSCRIPTION_NO,
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
