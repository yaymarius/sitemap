<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Test\Util\TestHelper;

final class UrlSetInterfaceTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testConstants()
    {
        $this->assertSame('xmlns', UrlSetInterface::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.sitemaps.org/schemas/sitemap/0.9', UrlSetInterface::XML_NAMESPACE_URI);

        $this->assertSame(50000, UrlSetInterface::URL_MAX_COUNT);
    }
}
