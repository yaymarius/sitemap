<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Image;

final class Image implements ImageInterface
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
     * @var string|null
     */
    private $caption;

    /**
     * @var string|null
     */
    private $geoLocation;

    /**
     * @var string|null
     */
    private $licence;

    /**
     * @param string $location
     */
    public function __construct($location)
    {
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

    public function caption()
    {
        return $this->caption;
    }

    public function geoLocation()
    {
        return $this->geoLocation;
    }

    public function licence()
    {
        return $this->licence;
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

    /**
     * @param string $caption
     *
     * @return static
     */
    public function withCaption($caption)
    {
        $instance = clone $this;

        $instance->caption = $caption;

        return $instance;
    }

    /**
     * @param string $geoLocation
     *
     * @return static
     */
    public function withGeoLocation($geoLocation)
    {
        $instance = clone $this;

        $instance->geoLocation = $geoLocation;

        return $instance;
    }

    /**
     * @param string $licence
     *
     * @return static
     */
    public function withLicence($licence)
    {
        $instance = clone $this;

        $instance->licence = $licence;

        return $instance;
    }
}
