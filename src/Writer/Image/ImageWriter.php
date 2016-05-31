<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\Image;

use Refinery29\Sitemap\Component\Image\ImageInterface;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
class ImageWriter
{
    public function write(ImageInterface $image, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('image:image');

        $this->writeLocation($xmlWriter, $image->location());
        $this->writeTitle($xmlWriter, $image->title());
        $this->writeCaption($xmlWriter, $image->caption());
        $this->writeGeoLocation($xmlWriter, $image->geoLocation());
        $this->writeLicence($xmlWriter, $image->licence());

        $xmlWriter->endElement();
    }

    private function writeLocation(\XMLWriter $xmlWriter, $location)
    {
        $xmlWriter->startElement('image:loc');
        $xmlWriter->text($location);
        $xmlWriter->endElement();
    }

    private function writeTitle(\XMLWriter $xmlWriter, $title = null)
    {
        if ($title === null) {
            return;
        }

        $xmlWriter->startElement('image:title');
        $xmlWriter->text($title);
        $xmlWriter->endElement();
    }

    private function writeCaption(\XMLWriter $xmlWriter, $caption = null)
    {
        if ($caption === null) {
            return;
        }

        $xmlWriter->startElement('image:caption');
        $xmlWriter->text($caption);
        $xmlWriter->endElement();
    }

    private function writeGeoLocation(\XMLWriter $xmlWriter, $geoLocation = null)
    {
        if ($geoLocation === null) {
            return;
        }

        $xmlWriter->startElement('image:geo_location');
        $xmlWriter->text($geoLocation);
        $xmlWriter->endElement();
    }

    private function writeLicence(\XMLWriter $xmlWriter, $licence = null)
    {
        if ($licence === null) {
            return;
        }

        $xmlWriter->startElement('image:licence');
        $xmlWriter->text($licence);
        $xmlWriter->endElement();
    }
}
