<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
interface UrlSetInterface
{
    /**
     * @param UrlInterface $url
     */
    public function addUrl(UrlInterface $url);

    /**
     * @return UrlInterface[]
     */
    public function getUrls();
}
