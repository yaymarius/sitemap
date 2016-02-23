<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\News;

use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class NewsInterfaceTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstants()
    {
        $this->assertSame('xmlns:news', NewsInterface::XML_NAMESPACE_ATTRIBUTE);
        $this->assertSame('http://www.google.com/schemas/sitemap-news/0.9', NewsInterface::XML_NAMESPACE_URI);

        $this->assertSame('Registration', NewsInterface::ACCESS_REGISTRATION);
        $this->assertSame('Subscription', NewsInterface::ACCESS_SUBSCRIPTION);

        $this->assertSame('Satire', NewsInterface::GENRE_SATIRE);
        $this->assertSame('Blog', NewsInterface::GENRE_BLOG);
        $this->assertSame('OpEd', NewsInterface::GENRE_OP_ED);
        $this->assertSame('Opinion', NewsInterface::GENRE_OPINION);
        $this->assertSame('UserGenerated', NewsInterface::GENRE_USER_GENERATED);

        $this->assertSame(5, NewsInterface::STOCK_TICKERS_MAX_COUNT);
    }
}
