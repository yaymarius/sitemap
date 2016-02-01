<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use BadMethodCallException;
use InvalidArgumentException;

final class Platform implements PlatformInterface
{
    /**
     * Constants for types.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TYPE_MOBILE = 'mobile';
    const TYPE_TV = 'tv';
    const TYPE_WEB = 'web';

    /**
     * Constants for resolutions.
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
    private $types = [];

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
            throw new InvalidArgumentException(sprintf(
                'Parameter "%s" needs to be specified as one of "%s"',
                'relationship',
                implode('", "', $allowedValues)
            ));
        }

        $this->relationship = $relationship;
    }

    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $type
     */
    public function addType($type)
    {
        $allowedValues = [
            self::TYPE_MOBILE,
            self::TYPE_TV,
            self::TYPE_WEB,
        ];

        if (!is_string($type) || !in_array($type, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Parameter "%s" needs to be specified as one of "%s"',
                'type',
                implode('", "', $allowedValues)
            ));
        }

        if (in_array($type, $this->types)) {
            throw new BadMethodCallException('Can not add the same type twice');
        }

        $this->types[] = $type;
    }

    public function getTypes()
    {
        return $this->types;
    }
}
