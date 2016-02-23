<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component\Video;

use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class RestrictionInterfaceTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstants()
    {
        $this->assertSame('allow', RestrictionInterface::RELATIONSHIP_ALLOW);
        $this->assertSame('deny', RestrictionInterface::RELATIONSHIP_DENY);
    }
}
