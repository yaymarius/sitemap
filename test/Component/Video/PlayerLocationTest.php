<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\PlayerLocation;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class PlayerLocationTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstants()
    {
        $this->assertSame('yes', PlayerLocationInterface::ALLOW_EMBED_YES);
        $this->assertSame('no', PlayerLocationInterface::ALLOW_EMBED_NO);
    }

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(PlayerLocation::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsInterface()
    {
        $playerLocation = new PlayerLocation($this->getFaker()->url);

        $this->assertInstanceOf(PlayerLocationInterface::class, $playerLocation);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $allowEmbed = $faker->randomElement([
            PlayerLocationInterface::ALLOW_EMBED_NO,
            PlayerLocationInterface::ALLOW_EMBED_YES,
        ]);
        $autoPlay = 'play=true';

        $playerLocation = new PlayerLocation(
            $location,
            $allowEmbed,
            $autoPlay
        );

        $this->assertSame($location, $playerLocation->getLocation());
        $this->assertSame($allowEmbed, $playerLocation->getAllowEmbed());
        $this->assertSame($autoPlay, $playerLocation->getAutoPlay());
    }

    public function testDefaults()
    {
        $playerLocation = new PlayerLocation($this->getFaker()->url);

        $this->assertNull($playerLocation->getAllowEmbed());
        $this->assertNull($playerLocation->getAutoPlay());
    }

    public function testInvalidAllowEmbedIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new PlayerLocation(
            $this->getFaker()->url,
            'foobarbaz'
        );
    }
}
