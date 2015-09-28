<?php

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
