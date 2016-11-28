<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;

final class PlayerLocationInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('yes', PlayerLocationInterface::ALLOW_EMBED_YES);
        $this->assertSame('no', PlayerLocationInterface::ALLOW_EMBED_NO);
    }
}
