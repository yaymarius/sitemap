<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\Platform;
use Refinery29\Sitemap\Component\Video\PlatformInterface;
use Refinery29\Test\Util\TestHelper;

final class PlatformTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(Platform::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsPlatformInterface()
    {
        $reflectionClass = new \ReflectionClass(Platform::class);

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

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $relationship
     */
    public function testConstructorRejectsInvalidValue($relationship)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new Platform($relationship);
    }

    /**
     * @dataProvider providerRelationship
     *
     * @param string $relationship
     */
    public function testConstructorSetsValue($relationship)
    {
        $platform = new Platform($relationship);

        $this->assertSame($relationship, $platform->relationship());
    }

    /**
     * @return \Generator
     */
    public function providerRelationship()
    {
        $values = [
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $type
     */
    public function testWithTypesRejectsInvalidValues($type)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $types = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            $type,
        ];

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->withTypes($types);
    }

    public function testWithTypesRejectsUnknownValues()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $types = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            $faker->sentence(),
        ];

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->withTypes($types);
    }

    /**
     * @dataProvider providerType
     *
     * @param string $type
     */
    public function testWithTypesRejectsDuplicateValues($type)
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $types = [
            $type,
            $type,
        ];

        $platform = new Platform($faker->randomElement([
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ]));

        $platform->withTypes($types);
    }

    /**
     * @return \Generator
     */
    public function providerType()
    {
        $values = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
