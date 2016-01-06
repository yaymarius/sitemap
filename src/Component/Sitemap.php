<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use DateTime;

final class Sitemap implements SitemapInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var DateTime|null
     */
    private $lastModified;

    /**
     * @param string        $location
     * @param DateTime|null $lastModified
     */
    public function __construct($location, DateTime $lastModified = null)
    {
        $this->location = $location;
        $this->lastModified = $lastModified;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getLastModified()
    {
        if ($this->lastModified === null) {
            return;
        }

        return clone $this->lastModified;
    }
}
