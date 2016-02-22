<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class PlayerLocation implements PlayerLocationInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $allowEmbed;

    /**
     * @var string|null
     */
    private $autoPlay;

    /**
     * @param string      $location
     * @param string|null $allowEmbed
     * @param string|null $autoPlay
     */
    public function __construct($location, $allowEmbed = null, $autoPlay = null)
    {
        $this->location = $location;

        $this->setAllowEmbed($allowEmbed);

        $this->autoPlay = $autoPlay;
    }

    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string|null $allowEmbed
     */
    private function setAllowEmbed($allowEmbed = null)
    {
        $choices = [
            PlayerLocationInterface::ALLOW_EMBED_NO,
            PlayerLocationInterface::ALLOW_EMBED_YES,
        ];

        Assertion::nullOrChoice($allowEmbed, $choices);

        $this->allowEmbed = $allowEmbed;
    }

    public function getAllowEmbed()
    {
        return $this->allowEmbed;
    }

    public function getAutoPlay()
    {
        return $this->autoPlay;
    }
}
