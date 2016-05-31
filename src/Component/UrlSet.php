<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Assert\Assertion;

final class UrlSet implements UrlSetInterface
{
    /**
     * @var UrlInterface[]
     */
    private $urls;

    /**
     * @param array[] $urls
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $urls)
    {
        Assertion::allIsInstanceOf($urls, UrlInterface::class);
        Assertion::lessOrEqualThan(count($urls), UrlSetInterface::URL_MAX_COUNT);

        $this->urls = $urls;
    }

    public function urls()
    {
        return $this->urls;
    }
}
