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
     * @param string      $location
     * @param string|null $title
     * @param string|null $caption
     * @param string|null $geoLocation
     * @param string|null $licence
     */
    public function __construct($location, $title = null, $caption = null, $geoLocation = null, $licence = null)
    {
        $this->location = $location;
        $this->title = $title;
        $this->caption = $caption;
        $this->geoLocation = $geoLocation;
        $this->licence = $licence;
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
}
