<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

use DateTime;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 */
interface SitemapInterface
{
    /**
     * @return string
     */
    public function getLocation();

    /**
     * @return DateTime|null
     */
    public function getLastModified();
}
