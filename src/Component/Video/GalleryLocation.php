<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;
use InvalidArgumentException;

final class GalleryLocation implements GalleryLocationInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @param string $location
     *
     * @throws InvalidArgumentException
     */
    public function __construct($location)
    {
        Assertion::url($location);

        $this->location = $location;
    }

    public function location()
    {
        return $this->location;
    }

    public function title()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return static
     */
    public function withTitle($title)
    {
        $instance = clone $this;

        $instance->title = $title;

        return $instance;
    }
}
