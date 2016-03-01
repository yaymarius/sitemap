<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Restriction;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class RestrictionTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Restriction::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsRestrictionInterface()
    {
        $reflectionClass = new ReflectionClass(Restriction::class);

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
     * @dataProvider providerInvalidRestriction
     *
     * @param mixed $restriction
     */
    public function testConstructorRejectsInvalidRestriction($restriction)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Restriction($restriction);
    }

    /**
     * @return \Generator
     */
    public function providerInvalidRestriction()
    {
        $values = [
            null,
            $this->getFaker()->sentence(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }

    public function testConstructorSetsValue()
    {
        $relationship = $this->getFaker()->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]);

        $restriction = new Restriction($relationship);

        $this->assertSame($relationship, $restriction->relationship());
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
