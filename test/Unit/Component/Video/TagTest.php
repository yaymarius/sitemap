<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\Tag;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Test\Util\TestHelper;

final class TagTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testIsFinal()
    {
        $reflectionClass = new \ReflectionClass(Tag::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsTagInterface()
    {
        $this->assertImplements(TagInterface::class, Tag::class);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $content
     */
    public function testConstructorRejectsInvalidValue($content)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Tag($content);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $content
     */
    public function testConstructorRejectsBlankString($content)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Tag($content);
    }

    public function testConstructorSetsValues()
    {
        $content = $this->getFaker()->word;

        $tag = new Tag($content);

        $this->assertSame($content, $tag->content());
    }
}
