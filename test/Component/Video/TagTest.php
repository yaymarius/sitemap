<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Component\Video;

use Refinery29\Sitemap\Component\Video\Tag;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Sitemap\Test\Util\FakerTrait;

class TagTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testImplementsInterface()
    {
        $tag = new Tag($this->getFaker()->word);

        $this->assertInstanceOf(TagInterface::class, $tag);
    }

    public function testConstructorSetsValues()
    {
        $content = $this->getFaker()->word;

        $tag = new Tag($content);

        $this->assertSame($content, $tag->getContent());
    }
}
