<?php

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\Restriction;
use Refinery29\Sitemap\Component\Video\RestrictionInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\RestrictionWriter;
use XMLWriter;

class RestrictionWriterTest extends AbstractTestCase
{
    public function testWriteRestriction()
    {
        $faker = $this->getFaker();

        $relationship = $faker->randomElement([
            Restriction::RELATIONSHIP_ALLOW,
            Restriction::RELATIONSHIP_DENY,
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

        $this->writesElement($xmlWriter, 'video:restriction', implode(' ', $countryCodes), [
            'relationship' => $relationship,
        ]);

        $writer = new RestrictionWriter();

        $writer->write($xmlWriter, $restriction);
    }

    /**
     * @param string $relationship
     * @param array  $countryCodes
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|RestrictionInterface
     */
    private function getRestrictionMock($relationship, array $countryCodes)
    {
        $restriction = $this->getMockBuilder(RestrictionInterface::class)->getMock();

        $restriction
            ->expects($this->any())
            ->method('getRelationship')
            ->willReturn($relationship)
        ;

        $restriction
            ->expects($this->any())
            ->method('getCountryCodes')
            ->willReturn($countryCodes)
        ;

        return $restriction;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
