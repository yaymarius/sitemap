<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Writer\Image;

use Refinery29\Sitemap\Component\Image\ImageInterface;
use XMLWriter;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
class ImageWriter
{
    public function write(XMLWriter $xmlWriter, ImageInterface $image)
    {
        $xmlWriter->startElement('image:image');

        $this->writeLocation($xmlWriter, $image->getLocation());
        $this->writeTitle($xmlWriter, $image->getTitle());
        $this->writeCaption($xmlWriter, $image->getCaption());
        $this->writeGeoLocation($xmlWriter, $image->getGeoLocation());
        $this->writeLicence($xmlWriter, $image->getLicence());

        $xmlWriter->endElement();
    }

    private function writeLocation(XMLWriter $xmlWriter, $location)
    {
        $xmlWriter->startElement('image:loc');
        $xmlWriter->text($location);
        $xmlWriter->endElement();
    }

    private function writeTitle(XMLWriter $xmlWriter, $title = null)
    {
        if ($title === null) {
            return;
        }

        $xmlWriter->startElement('image:title');
        $xmlWriter->text($title);
        $xmlWriter->endElement();
    }

    private function writeCaption(XMLWriter $xmlWriter, $caption = null)
    {
        if ($caption === null) {
            return;
        }

        $xmlWriter->startElement('image:caption');
        $xmlWriter->text($caption);
        $xmlWriter->endElement();
    }

    private function writeGeoLocation(XMLWriter $xmlWriter, $geoLocation = null)
    {
        if ($geoLocation === null) {
            return;
        }

        $xmlWriter->startElement('image:geo_location');
        $xmlWriter->text($geoLocation);
        $xmlWriter->endElement();
    }

    private function writeLicence(XMLWriter $xmlWriter, $licence = null)
    {
        if ($licence === null) {
            return;
        }

        $xmlWriter->startElement('image:licence');
        $xmlWriter->text($licence);
        $xmlWriter->endElement();
    }
}
