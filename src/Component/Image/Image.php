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
     * Constants for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns:image';
    const XML_NAMESPACE_URI = 'http://www.google.com/schemas/sitemap-image/1.1';

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

    public function getLocation()
    {
        return $this->location;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    public function getLicence()
    {
        return $this->licence;
    }
}
