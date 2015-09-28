<?php

namespace Refinery29\Sitemap\Component;

final class UrlSet implements UrlSetInterface
{
    /**
     * Constant for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns';
    const XML_NAMESPACE_URI = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * @var UrlInterface[]
     */
    private $urls = [];

    public function addUrl(UrlInterface $url)
    {
        $this->urls[] = $url;
    }

    public function getUrls()
    {
        return $this->urls;
    }
}
