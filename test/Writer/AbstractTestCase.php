<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Writer;

use Refinery29\Sitemap\Test\Util\FakerTrait;
use SplObjectStorage;

abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $xmlWriter
     * @param string                                   $name
     */
    protected function expectToStartElement(\PHPUnit_Framework_MockObject_MockObject $xmlWriter, $name)
    {
        $xmlWriter
            ->expects($this->next($xmlWriter))
            ->method('startElement')
            ->with($this->identicalTo($name))
        ;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $xmlWriter
     * @param string                                   $name
     * @param mixed                                    $value
     */
    protected function expectToWriteAttribute(\PHPUnit_Framework_MockObject_MockObject $xmlWriter, $name, $value)
    {
        $xmlWriter
            ->expects($this->next($xmlWriter))
            ->method('writeAttribute')
            ->with(
                $this->identicalTo($name),
                $this->identicalTo($value)
            )
        ;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $xmlWriter
     */
    protected function expectToEndElement(\PHPUnit_Framework_MockObject_MockObject $xmlWriter)
    {
        $xmlWriter
            ->expects($this->next($xmlWriter))
            ->method('endElement')
        ;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $xmlWriter
     * @param string                                   $name
     * @param mixed                                    $text
     * @param array                                    $attributes
     */
    protected function expectToWriteElement(\PHPUnit_Framework_MockObject_MockObject $xmlWriter, $name, $text = null, array $attributes = [])
    {
        $this->expectToStartElement($xmlWriter, $name);

        foreach ($attributes as $name => $value) {
            $this->expectToWriteAttribute($xmlWriter, $name, $value);
        }

        if ($text !== null) {
            $xmlWriter
                ->expects($this->next($xmlWriter))
                ->method('text')
                ->with($this->identicalTo($text))
            ;
        }

        $this->expectToEndElement($xmlWriter);
    }

    /**
     * Returns a matcher which matches the next invocation of a method on the mocked object.
     *
     * @param \PHPUnit_Framework_MockObject_MockObject $mockObject
     *
     * @return \PHPUnit_Framework_MockObject_Matcher_InvokedAtIndex
     */
    protected function next(\PHPUnit_Framework_MockObject_MockObject $mockObject)
    {
        static $invocations;

        if ($invocations === null) {
            $invocations = new SplObjectStorage();
        }

        $invocation = 0;

        if (!$invocations->offsetExists($mockObject)) {
            $invocations->offsetSet($mockObject, $invocation);
        } else {
            $invocation = $invocations->offsetGet($mockObject) + 1;
            $invocations->offsetSet($mockObject, $invocation);
        }

        return $this->at($invocation);
    }
}
