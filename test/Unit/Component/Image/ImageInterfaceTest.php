<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Image;

use Refinery29\Sitemap\Component\Image\ImageInterface;

class ImageInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('xmlns:image', ImageInterface::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.google.com/schemas/sitemap-image/1.1', ImageInterface::XML_NAMESPACE_URI);
    }
}
