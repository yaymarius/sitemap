<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Test\Unit\Writer\Video;

use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\RestrictionWriter;

final class RestrictionWriterTest extends AbstractTestCase
{
    public function testWriteRestriction()
    {
        $faker = $this->getFaker();

        $relationship = $faker->randomElement([
            RestrictionInterface::RELATIONSHIP_ALLOW,
            RestrictionInterface::RELATIONSHIP_DENY,
        ]);

        $countryCodes = [
            $faker->countryCode,
            $faker->countryCode,
            $faker->countryCode,
        ];

        $restriction = $this->getRestrictionMock(
            $relationship,
            $countryCodes
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:restriction', implode(' ', $countryCodes), [
            'relationship' => $relationship,
        ]);

        $writer = new RestrictionWriter();

        $writer->write($restriction, $xmlWriter);
    }

    /**
     * @param string $relationship
     * @param array  $countryCodes
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|RestrictionInterface
     */
    private function getRestrictionMock($relationship, array $countryCodes)
    {
        $restriction = $this->getMock(RestrictionInterface::class);

        $restriction
            ->expects($this->any())
            ->method('relationship')
            ->willReturn($relationship);

        $restriction
            ->expects($this->any())
            ->method('countryCodes')
            ->willReturn($countryCodes);

        return $restriction;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMock(\XMLWriter::class);
    }
}
