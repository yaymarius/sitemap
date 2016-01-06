<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer\News;

use Refinery29\Sitemap\Component\News\PublicationInterface;
use XMLWriter;

/**
 * @link https://support.google.com/news/publisher/answer/74288?hl=en#exampleentry
 */
class PublicationWriter
{
    /**
     * @param XMLWriter            $xmlWriter
     * @param PublicationInterface $publication
     */
    public function write(XMLWriter $xmlWriter, PublicationInterface $publication)
    {
        $xmlWriter->startElement('news:publication');

        $this->writeName($xmlWriter, $publication->getName());
        $this->writeLanguage($xmlWriter, $publication->getLanguage());

        $xmlWriter->endElement();
    }

    private function writeName(XMLWriter $xmlWriter, $name)
    {
        $xmlWriter->startElement('news:name');
        $xmlWriter->text($name);
        $xmlWriter->endElement();
    }

    private function writeLanguage(XMLWriter $xmlWriter, $language)
    {
        $xmlWriter->startElement('news:language');
        $xmlWriter->text($language);
        $xmlWriter->endElement();
    }
}
