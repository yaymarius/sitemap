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
use Refinery29\Sitemap\Component\Video\Platform;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class PlatformTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstants()
    {
        $this->assertSame('allow', Platform::RELATIONSHIP_ALLOW);
        $this->assertSame('deny', Platform::RELATIONSHIP_DENY);

        $this->assertSame('mobile', Platform::TYPE_MOBILE);
        $this->assertSame('tv', Platform::TYPE_TV);
        $this->assertSame('web', Platform::TYPE_WEB);
    }

    public function testImplementsInterface()
    {
        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]));

        $this->assertInstanceOf(PlatformInterface::class, $platform);
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $relationship = $faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]);

        $platform = new Platform($relationship);

        $this->assertSame($relationship, $platform->getRelationship());
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]));

        $this->assertInternalType('array', $platform->getTypes());
        $this->assertCount(0, $platform->getTypes());
    }

    public function testInvalidRelationshipIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Platform('foo');
    }

    public function testCanAddType()
    {
        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]));

        $type = $faker->randomElement([
            Platform::TYPE_MOBILE,
            Platform::TYPE_TV,
            Platform::TYPE_WEB,
        ]);

        $platform->addType($type);

        $this->assertInternalType('array', $platform->getTypes());
        $this->assertCount(1, $platform->getTypes());
        $this->assertSame($type, $platform->getTypes()[0]);
    }

    public function testCanNotAddSameTypeTwice()
    {
        $this->setExpectedException(BadMethodCallException::class);

        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]));

        $type = $faker->randomElement([
            Platform::TYPE_MOBILE,
            Platform::TYPE_TV,
            Platform::TYPE_WEB,
        ]);

        $platform->addType($type);
        $platform->addType($type);
    }

    public function testInvalidTypeIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            Platform::RELATIONSHIP_ALLOW,
            Platform::RELATIONSHIP_DENY,
        ]));

        $platform->addType('foobarbaz');
    }
}
