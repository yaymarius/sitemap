<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\GalleryLocationInterface;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Component\Video\PriceInterface;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Component\Video\Video;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Test\Util\TestHelper;

final class VideoTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $this->assertFinal(Video::class);
    }

    public function testImplementsVideoInterface()
    {
        $reflectionClass = new \ReflectionClass(Video::class);

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
        $this->expectException(\InvalidArgumentException::class);

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
        $this->expectException(\InvalidArgumentException::class);

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
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidInteger::data()
     *
     * @param mixed $duration
     */
    public function testWithDurationRejectsInvalidValue($duration)
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider providerOutOfBoundsDuration
     *
     * @param mixed $duration
     */
    public function testWithDurationRejectsOutOfBoundsValue($duration)
    {
        $this->expectException(\InvalidArgumentException::class);

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
    public function providerOutOfBoundsDuration()
    {
        return $this->provideData([
            VideoInterface::DURATION_LOWER_LIMIT - 1,
            VideoInterface::DURATION_LOWER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT,
            VideoInterface::DURATION_UPPER_LIMIT + 1,
        ]);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidFloat::data()
     *
     * @param mixed $rating
     */
    public function testWithRatingRejectsInvalidValue($rating)
    {
        $this->expectException(\InvalidArgumentException::class);

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
     * @dataProvider providerOutOfBoundsRating
     *
     * @param mixed $rating
     */
    public function testWithRatingRejectsOutOfBoundsValue($rating)
    {
        $this->expectException(\InvalidArgumentException::class);

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
    public function providerOutOfBoundsRating()
    {
        return $this->provideData([
            VideoInterface::RATING_MIN - 0.1,
            VideoInterface::RATING_MAX + 0.1,
        ]);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidInteger::data()
     *
     * @param mixed $viewCount
     */
    public function testWithViewCountRejectsInvalidValue($viewCount)
    {
        $this->expectException(\InvalidArgumentException::class);

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

    public function testWithViewCountRejectsNegativeValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $viewCount = VideoInterface::VIEW_COUNT_MIN - 1;

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withViewCount($viewCount);
    }

    public function testWithViewCountClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $viewCount = $faker->numberBetween(VideoInterface::VIEW_COUNT_MIN);

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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $familyFriendly
     */
    public function testWithFamilyFriendlyRejectsInvalidValue($familyFriendly)
    {
        $this->expectException(\InvalidArgumentException::class);

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

    public function testWithFamilyFriendlyRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $familyFriendly = $faker->sentence();

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withFamilyFriendly($familyFriendly);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $tag
     */
    public function testWithTagsRejectsInvalidValue($tag)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $tags = [
            $faker->word,
            $faker->word,
            $tag,
        ];

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withTags($tags);
    }

    public function testWithTagsRejectsTooManyValues()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $tags = array_fill(
            0,
            VideoInterface::TAG_MAX_COUNT + 1,
            $this->getTagMock()
        );

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withTags($tags);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $category
     */
    public function testWithCategoryRejectsInvalidValue($category)
    {
        $this->expectException(\InvalidArgumentException::class);

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

    public function testWithCategoryRejectsTooLongValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $category = str_repeat(
            'a',
            VideoInterface::CATEGORY_MAX_LENGTH + 1
        );

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withCategory($category);
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

    public function testWithPricesRejectsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $prices = [
            $this->getPriceMock(),
            $this->getPriceMock(),
            new \stdClass(),
        ];

        $video = new Video(
            $faker->url,
            $faker->sentence,
            $faker->paragraphs(5, true),
            $faker->url,
            $this->getPlayerLocationMock()
        );

        $video->withPrices($prices);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $requiresSubscription
     */
    public function testWithRequiresSubscriptionRejectsInvalidValue($requiresSubscription)
    {
        $this->expectException(\InvalidArgumentException::class);

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

    public function testWithRequiresSubscriptionRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $requiresSubscription = $faker->sentence();

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
     * @dataProvider providerRequiresSubscription
     *
     * @param string $requiresSubscription
     */
    public function testWithRequiresSubscriptionClonesObjectAndSetsValue($requiresSubscription)
    {
        $faker = $this->getFaker();

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

    /**
     * @return \Generator
     */
    public function providerRequiresSubscription()
    {
        return $this->provideData([
            VideoInterface::REQUIRES_SUBSCRIPTION_NO,
            VideoInterface::REQUIRES_SUBSCRIPTION_YES,
        ]);
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
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $live
     */
    public function testWithLiveRejectsInvalidValue($live)
    {
        $this->expectException(\InvalidArgumentException::class);

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

    public function testWithLiveRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $live = $faker->sentence();

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
     * @dataProvider providerLive
     *
     * @param string $live
     */
    public function testWithLiveClonesObjectAndSetsValue($live)
    {
        $faker = $this->getFaker();

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
    public function providerLive()
    {
        return $this->provideData([
            VideoInterface::LIVE_NO,
            VideoInterface::LIVE_YES,
        ]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|GalleryLocationInterface
     */
    private function getGalleryLocationMock()
    {
        return $this->createMock(GalleryLocationInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PlatformInterface
     */
    private function getPlatformMock()
    {
        return $this->createMock(PlatformInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PlayerLocationInterface
     */
    private function getPlayerLocationMock()
    {
        return $this->createMock(PlayerLocationInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PriceInterface
     */
    private function getPriceMock()
    {
        return $this->createMock(PriceInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RestrictionInterface
     */
    private function getRestrictionMock()
    {
        return $this->createMock(RestrictionInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TagInterface
     */
    private function getTagMock()
    {
        return $this->createMock(TagInterface::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|UploaderInterface
     */
    private function getUploaderMock()
    {
        return $this->createMock(UploaderInterface::class);
    }
}
