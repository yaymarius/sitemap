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

    public function testDefaults()
    {
        $platform = new Platform($this->getFaker()->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $this->assertInternalType('array', $platform->types());
        $this->assertCount(0, $platform->types());
    }

    public function testConstructorRejectsInvalidRelationship()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Platform('foo');
    }

    public function testConstructorSetsValue()
    {
        $relationship = $this->getFaker()->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]);

        $platform = new Platform($relationship);

        $this->assertSame($relationship, $platform->relationship());
    }

    public function testWithTypesRejectsInvalidValues()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $types = $faker->words;

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->withTypes($types);
    }

    public function testWithTypesRejectsDuplicateValues()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $faker = $this->getFaker();

        $types = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_MOBILE,
        ];

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->withTypes($types);
    }

    public function testWithTypesClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $types = $faker->randomElements([
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ]);

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $instance = $platform->withTypes($types);

        $this->assertInstanceOf(Platform::class, $instance);
        $this->assertNotSame($platform, $instance);
        $this->assertSame($types, $instance->types());
    }
}
