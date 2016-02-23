<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\PriceInterface;

class PriceInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('own', PriceInterface::TYPE_OWN);
        $this->assertSame('rent', PriceInterface::TYPE_RENT);

        $this->assertSame('HD', PriceInterface::RESOLUTION_HD);
        $this->assertSame('SD', PriceInterface::RESOLUTION_SD);
    }
}
