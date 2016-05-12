<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use InvalidArgumentException;
use Refinery29\Sitemap\Component\Video\Tag;
use Refinery29\Sitemap\Component\Video\TagInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class TagTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testIsFinal()
    {
        $reflectionClass = new ReflectionClass(Tag::class);

        $this->assertTrue($reflectionClass->isFinal());
    }

    public function testImplementsTagInterface()
    {
        $reflectionClass = new ReflectionClass(Tag::class);

        $this->assertTrue($reflectionClass->implementsInterface(TagInterface::class));
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $content
     */
    public function testConstructorRejectsInvalidContent($content)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        new Tag($content);
    }

    public function testConstructorSetsValues()
    {
        $content = $this->getFaker()->word;

        $tag = new Tag($content);

        $this->assertSame($content, $tag->content());
    }
}
