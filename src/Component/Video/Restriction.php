<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

final class Restriction implements RestrictionInterface
{
    /**
     * Constants for relationships.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const RELATIONSHIP_ALLOW = 'allow';
    const RELATIONSHIP_DENY = 'deny';

    /**
     * @var string
     */
    private $relationship;

    /**
     * @var array
     */
    private $countryCodes = [];

    /**
     * @param string $relationship
     */
    public function __construct($relationship)
    {
        $this->setRelationship($relationship);
    }

    /**
     * @param string $relationship
     */
    private function setRelationship($relationship)
    {
        $allowedValues = [
            self::RELATIONSHIP_ALLOW,
            self::RELATIONSHIP_DENY,
        ];

        if (!is_string($relationship) || !in_array($relationship, $allowedValues)) {
            throw new \InvalidArgumentException(sprintf(
                'Parameter "%s" needs to be specified as one of "%s"',
                'relationship',
                implode('", "', $allowedValues)
            ));
        }

        $this->relationship = $relationship;
    }

    /**
     * @return string
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $countryCode
     */
    public function addCountryCode($countryCode)
    {
        $this->countryCodes[] = $countryCode;
    }

    /**
     * @return array
     */
    public function getCountryCodes()
    {
        return $this->countryCodes;
    }
}
