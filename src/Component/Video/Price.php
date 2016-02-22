<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Price implements PriceInterface
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $resolution;

    /**
     * @param float       $value
     * @param string      $currency
     * @param string|null $type
     * @param string|null $resolution
     */
    public function __construct($value, $currency, $type = null, $resolution = null)
    {
        $this->setValue($value);

        $this->currency = $currency;

        $this->setType($type);
        $this->setResolution($resolution);
    }

    /**
     * @param float $value
     */
    private function setValue($value)
    {
        Assertion::greaterOrEqualThan($value, PriceInterface::VALUE_MIN);

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string|null $type
     */
    private function setType($type = null)
    {
        $allowedValues = [
            PriceInterface::TYPE_OWN,
            PriceInterface::TYPE_RENT,
        ];

        Assertion::nullOrChoice($type, $allowedValues);

        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|null $resolution
     */
    private function setResolution($resolution = null)
    {
        $allowedValues = [
            PriceInterface::RESOLUTION_HD,
            PriceInterface::RESOLUTION_SD,
        ];

        Assertion::nullOrChoice($resolution, $allowedValues);

        $this->resolution = $resolution;
    }

    public function getResolution()
    {
        return $this->resolution;
    }
}
