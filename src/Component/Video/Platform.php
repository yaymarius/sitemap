<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Platform implements PlatformInterface
{
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
        $choices = [
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ];

        Assertion::choice($relationship, $choices);

        $this->relationship = $relationship;
    }

    public function relationship()
    {
        return $this->relationship;
    }

    /**
     * @param string $type
     */
    public function addType($type)
    {
        $choices = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ];

        Assertion::choice($type, $choices);
        Assertion::false(in_array($type, $this->types));

        $this->types[] = $type;
    }

    public function types()
    {
        return $this->types;
    }
}
