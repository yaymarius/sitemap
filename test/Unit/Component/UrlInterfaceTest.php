<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Sitemap\Component\UrlInterface;

final class UrlInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('always', UrlInterface::CHANGE_FREQUENCY_ALWAYS);
        $this->assertSame('hourly', UrlInterface::CHANGE_FREQUENCY_HOURLY);
        $this->assertSame('daily', UrlInterface::CHANGE_FREQUENCY_DAILY);
        $this->assertSame('weekly', UrlInterface::CHANGE_FREQUENCY_WEEKLY);
        $this->assertSame('monthly', UrlInterface::CHANGE_FREQUENCY_MONTHLY);
        $this->assertSame('yearly', UrlInterface::CHANGE_FREQUENCY_YEARLY);
        $this->assertSame('never', UrlInterface::CHANGE_FREQUENCY_NEVER);

        $this->assertSame(0.0, UrlInterface::PRIORITY_MIN);
        $this->assertSame(1.0, UrlInterface::PRIORITY_MAX);
    }
}
