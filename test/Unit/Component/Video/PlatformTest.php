<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Platform;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class PlatformTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Platform::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsPlatformInterface()
    {
        $reflectionClass = new ReflectionClass(Platform::class);

        $this->assertTrue($reflectionClass->implementsInterface(PlatformInterface::class));
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $relationship = $faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]);

        $platform = new Platform($relationship);

        $this->assertSame($relationship, $platform->relationship());
    }

    public function testDefaults()
    {
        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $this->assertInternalType('array', $platform->types());
        $this->assertCount(0, $platform->types());
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
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $type = $faker->randomElement([
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ]);

        $platform->addType($type);

        $this->assertInternalType('array', $platform->types());
        $this->assertCount(1, $platform->types());
        $this->assertSame($type, $platform->types()[0]);
    }

    public function testCanNotAddSameTypeTwice()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $type = $faker->randomElement([
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ]);

        $platform->addType($type);
        $platform->addType($type);
    }

    public function testInvalidTypeIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->addType('foobarbaz');
    }
}
