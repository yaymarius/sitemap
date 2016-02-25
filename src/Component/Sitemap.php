<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component;

use DateTimeInterface;

final class Sitemap implements SitemapInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var DateTimeInterface|null
     */
    private $lastModified;

    /**
     * @param string                 $location
     * @param DateTimeInterface|null $lastModified
     */
    public function __construct($location, DateTimeInterface $lastModified = null)
    {
        $this->location = $location;
        $this->lastModified = $lastModified;
    }

    public function location()
    {
        return $this->location;
    }

    public function lastModified()
    {
        if ($this->lastModified === null) {
            return;
        }

        return clone $this->lastModified;
    }
}
