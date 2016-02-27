<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Restriction implements RestrictionInterface
{
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
        $choices = [
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ];

        Assertion::choice($relationship, $choices);

        $this->relationship = $relationship;
    }

    public function relationship()
    {
        return $this->relationship;
    }

    public function countryCodes()
    {
        return $this->countryCodes;
    }

    /**
     * @param array $countryCodes
     *
     * @return static
     */
    public function withCountryCodes(array $countryCodes)
    {
        $instance = clone $this;

        $instance->countryCodes = $countryCodes;

        return $instance;
    }
}
