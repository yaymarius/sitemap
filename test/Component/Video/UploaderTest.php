<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Component\Video;

use Refinery29\Sitemap\Component\Video\Uploader;
use Refinery29\Sitemap\Component\Video\UploaderInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class UploaderTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testImplementsInterface()
    {
        $uploader = new Uploader($this->getFaker()->name);

        $this->assertInstanceOf(UploaderInterface::class, $uploader);
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
