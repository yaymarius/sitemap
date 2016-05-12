<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\News;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\News\Publication;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class PublicationTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Publication::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsPublicationInterface()
    {
        $reflectionClass = new ReflectionClass(Publication::class);

        $this->assertTrue($reflectionClass->implementsInterface(PublicationInterface::class));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidName($name)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $language = $this->getFaker()->languageCode;

        new Publication(
            $name,
            $language
        );
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $language
     */
    public function testConstructorRejectsInvalidLanguage($language)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        $name = $this->getFaker()->sentence();

        new Publication(
            $name,
            $language
        );
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $name = $faker->name;
        $language = $faker->languageCode;

        $publication = new Publication(
            $name,
            $language
        );

        $this->assertSame($name, $publication->name());
        $this->assertSame($language, $publication->language());
    }
}
