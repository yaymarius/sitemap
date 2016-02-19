<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Component\Video;

use Refinery29\Sitemap\Component\Video\PlatformInterface;

class PlatformInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('allow', PlatformInterface::RELATIONSHIP_ALLOW);
        $this->assertSame('deny', PlatformInterface::RELATIONSHIP_DENY);

        $this->assertSame('mobile', PlatformInterface::TYPE_MOBILE);
        $this->assertSame('tv', PlatformInterface::TYPE_TV);
        $this->assertSame('web', PlatformInterface::TYPE_WEB);
    }
}
