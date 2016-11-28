<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\VideoInterface;

final class VideoInterfaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertSame('xmlns:video', VideoInterface::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.google.com/schemas/sitemap-video/1.1', VideoInterface::XML_NAMESPACE_URI);

        $this->assertSame(100, VideoInterface::TITLE_MAX_LENGTH);

        $this->assertSame(0, VideoInterface::DURATION_LOWER_LIMIT);
        $this->assertSame(28800, VideoInterface::DURATION_UPPER_LIMIT);

        $this->assertSame(0.0, VideoInterface::RATING_MIN);
        $this->assertSame(5.0, VideoInterface::RATING_MAX);

        $this->assertSame(0, VideoInterface::VIEW_COUNT_MIN);

        $this->assertSame('yes', VideoInterface::REQUIRES_SUBSCRIPTION_YES);
        $this->assertSame('no', VideoInterface::REQUIRES_SUBSCRIPTION_NO);

        $this->assertSame('no', VideoInterface::FAMILY_FRIENDLY_NO);

        $this->assertSame(256, VideoInterface::CATEGORY_MAX_LENGTH);

        $this->assertSame(32, VideoInterface::TAG_MAX_COUNT);
    }
}
