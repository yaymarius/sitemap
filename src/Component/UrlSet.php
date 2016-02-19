<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

final class UrlSet implements UrlSetInterface
{
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
