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
     * Constant for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns';
    const XML_NAMESPACE_URI = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * Constant for the maximum number of URLs which can be added to a UrlSet.
     */
    const URL_MAX_COUNT = 50000;

    /**
     * @return UrlInterface[]
     */
    public function urls();
}
