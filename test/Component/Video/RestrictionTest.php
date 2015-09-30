<?php

namespace Refinery29\Sitemap\Test\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Restriction;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class RestrictionTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testConstants()
    {
        $this->assertSame('allow', Restriction::RELATIONSHIP_ALLOW);
        $this->assertSame('deny', Restriction::RELATIONSHIP_DENY);
    }

    public function testImplementsInterface()
    {
        $restriction = new Restriction($this->getFaker()->randomElement([
            Restriction::RELATIONSHIP_ALLOW,
            Restriction::RELATIONSHIP_DENY,
        ]));

        $this->assertInstanceOf(RestrictionInterface::class, $restriction);
    }

    public function testConstructorSetsValues()
    {
        $relationship = $this->getFaker()->randomElement([
            Restriction::RELATIONSHIP_ALLOW,
            Restriction::RELATIONSHIP_DENY,
        ]);

        $restriction = new Restriction($relationship);

        $this->assertSame($relationship, $restriction->getRelationship());
    }

    public function testDefaults()
    {
        $relationship = $this->getFaker()->randomElement([
            Restriction::RELATIONSHIP_ALLOW,
            Restriction::RELATIONSHIP_DENY,
        ]);

        $restriction = new Restriction($relationship);

        $this->assertInternalType('array', $restriction->getCountryCodes());
        $this->assertCount(0, $restriction->getCountryCodes());
    }

    public function testInvalidRestrictionIsRejected()
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Restriction('foobarbaz');
    }

    public function testCanAddCountryCodes()
    {
        $faker = $this->getFaker();

        $countryCodes = [
            $faker->unique()->countryCode,
            $faker->unique()->countryCode,
        ];

        $relationship = $faker->randomElement([
            Restriction::RELATIONSHIP_ALLOW,
            Restriction::RELATIONSHIP_DENY,
        ]);

        $restriction = new Restriction($relationship);

        foreach ($countryCodes as $countryCode) {
            $restriction->addCountryCode($countryCode);
        }

        $this->assertSame($countryCodes, $restriction->getCountryCodes());
    }
}
