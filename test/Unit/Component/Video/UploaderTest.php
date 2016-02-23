<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\Uploader;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class UploaderTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Uploader::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsUploaderInterface()
    {
        $reflectionClass = new ReflectionClass(Uploader::class);

        $this->assertTrue($reflectionClass->implementsInterface(UploaderInterface::class));
    }

    public function testConstructorSetsValues()
    {
        $faker = $this->getFaker();

        $name = $faker->name;
        $info = $faker->url;

        $videoUploader = new Uploader(
            $name,
            $info
        );

        $this->assertSame($name, $videoUploader->getName());
        $this->assertSame($info, $videoUploader->getInfo());
    }

    public function testDefaults()
    {
        $videoUploader = new Uploader($this->getFaker()->name);

        $this->assertNull($videoUploader->getInfo());
    }
}
