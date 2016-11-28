<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\Restriction;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Test\Util\TestHelper;

final class RestrictionTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(Restriction::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsRestrictionInterface()
    {
        $reflectionClass = new \ReflectionClass(Restriction::class);

        $this->assertTrue($reflectionClass->implementsInterface(RestrictionInterface::class));
    }

    public function testDefaults()
    {
        $relationship = $this->getFaker()->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]);

        $restriction = new Restriction($relationship);

        $this->assertInternalType('array', $restriction->countryCodes());
        $this->assertCount(0, $restriction->countryCodes());
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $restriction
     */
    public function testConstructorRejectsInvalidValue($restriction)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Restriction($restriction);
    }

    public function testConstructorRejectsUnknownValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $relationship = $this->getFaker()->sentence();

        new Restriction($relationship);
    }

    /**
     * @dataProvider providerRelationship
     *
     * @param string $relationship
     */
    public function testConstructorSetsValue($relationship)
    {
        $restriction = new Restriction($relationship);

        $this->assertSame($relationship, $restriction->relationship());
    }

    /**
     * @return \Generator
     */
    public function providerRelationship()
    {
        $values = [
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $countryCode
     */
    public function testWithCountryCodeRejectsInvalidCountryCodes($countryCode)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $countryCodes = [
            $faker->countryCode,
            $countryCode,
        ];

        $restriction = new Restriction(
            $faker->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]));

        $restriction->withCountryCodes($countryCodes);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $countryCode
     */
    public function testWithCountryCodeRejectsBlankCountryCodes($countryCode)
    {
        $this->expectException(\InvalidArgumentException::class);

        $faker = $this->getFaker();

        $countryCodes = [
            $faker->countryCode,
            $countryCode,
        ];

        $restriction = new Restriction(
            $faker->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]));

        $restriction->withCountryCodes($countryCodes);
    }

    public function testWithCountryCodesClonesObjectAndSetsValue()
    {
        $faker = $this->getFaker();

        $countryCodes = [
            $faker->countryCode,
            $faker->countryCode,
            $faker->countryCode,
        ];

        $restriction = new Restriction($faker->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]));

        $instance = $restriction->withCountryCodes($countryCodes);

        $this->assertInstanceOf(Restriction::class, $instance);
        $this->assertNotSame($restriction, $instance);
        $this->assertSame($countryCodes, $instance->countryCodes());
    }
}
