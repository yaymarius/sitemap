<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\Video;

use InvalidArgumentException;

final class Price implements PriceInterface
{
    /**
     * Constant for minimum value.
     */
    const VALUE_MIN = 0.01;

    /**
     * Constants for types.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const TYPE_OWN = 'own';
    const TYPE_RENT = 'rent';

    /**
     * Constants for resolutions.
     *
     * @link https://developers.google.com/webmasters/videosearch/sitemaps#video-sitemap-tag-definitions
     */
    const RESOLUTION_HD = 'HD';
    const RESOLUTION_SD = 'SD';

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
        if (!is_numeric($value) || $value < self::VALUE_MIN) {
            throw new InvalidArgumentException(sprintf(
                'Parameter "%s" needs to be specified as a number greater than "%s"',
                $value,
                self::VALUE_MIN
            ));
        }

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
        if ($type === null) {
            return;
        }

        $allowedValues = [
            self::TYPE_OWN,
            self::TYPE_RENT,
        ];

        if (!is_string($type) || !in_array($type, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as one of "%s"',
                'type',
                implode('", "', $allowedValues)
            ));
        }

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
        if ($resolution === null) {
            return;
        }

        $allowedValues = [
            self::RESOLUTION_HD,
            self::RESOLUTION_SD,
        ];

        if (!is_string($resolution) || !in_array($resolution, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as one of "%s"',
                'resolution',
                implode('", "', $allowedValues)
            ));
        }

        $this->resolution = $resolution;
    }

    public function getResolution()
    {
        return $this->resolution;
    }
}
