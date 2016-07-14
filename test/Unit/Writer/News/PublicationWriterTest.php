<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer\News;

use Refinery29\Sitemap\Component\News\PublicationInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\News\PublicationWriter;

class PublicationWriterTest extends AbstractTestCase
{
    public function testWritePublication()
    {
        $faker = $this->getFaker();

        $name = $faker->name;
        $language = $faker->languageCode;

        $publication = $this->getPublicationMock(
            $name,
            $language
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToStartElement($xmlWriter, 'news:publication');

        $this->expectToWriteElement($xmlWriter, 'news:name', $name);
        $this->expectToWriteElement($xmlWriter, 'news:language', $language);

        $this->expectToEndElement($xmlWriter);

        $writer = new PublicationWriter();

        $writer->write($publication, $xmlWriter);
    }

    /**
     * @param string $name
     * @param string $language
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Refinery29\Sitemap\Component\News\PublicationInterface
     */
    private function getPublicationMock($name, $language)
    {
        $publication = $this->getMock(PublicationInterface::class);

        $publication
            ->expects($this->any())
            ->method('name')
            ->willReturn($name);

        $publication
            ->expects($this->any())
            ->method('language')
            ->willReturn($language);

        return $publication;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMock(\XMLWriter::class);
    }
}
