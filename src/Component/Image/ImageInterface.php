<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Image;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
interface ImageInterface
{
    /**
     * Constants for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns:image';
    const XML_NAMESPACE_URI = 'http://www.google.com/schemas/sitemap-image/1.1';

    /**
     * @return string
     */
    public function location();

    /**
     * @return string|null
     */
    public function title();

    /**
     * @return string|null
     */
    public function caption();

    /**
     * @return string|null
     */
    public function geoLocation();

    /**
     * @return string|null
     */
    public function licence();
}
