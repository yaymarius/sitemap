<?php

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
