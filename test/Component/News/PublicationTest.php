<?php

namespace Refinery29\Sitemap\Test\Component\News;

use Refinery29\Sitemap\Component\News\Publication;
use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class PublicationTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testImplementsInterface()
    {
        $faker = $this->getFaker();

        $publication = new Publication(
            $faker->name,
            $faker->languageCode
        );

        $this->assertInstanceOf(PublicationInterface::class, $publication);
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

        $this->assertSame($name, $publication->getName());
        $this->assertSame($language, $publication->getLanguage());
    }
}
