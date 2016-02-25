<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Writer\Video;

use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Test\Unit\Writer\AbstractTestCase;
use Refinery29\Sitemap\Writer\Video\PlayerLocationWriter;
use XMLWriter;

class PlayerLocationWriterTest extends AbstractTestCase
{
    public function testWriteSimplePlayerLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;

        $playerLocation = $this->getPlayerLocationMock($location);

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:player_loc', $location);

        $writer = new PlayerLocationWriter();

        $writer->write($playerLocation, $xmlWriter);
    }

    public function testWriteAdvancedPlayerLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $allowEmbed = $faker->randomElement([
            PlayerLocationInterface::ALLOW_EMBED_NO,
            PlayerLocationInterface::ALLOW_EMBED_YES,
        ]);
        $autoPlay = 'play=yes';

        $playerLocation = $this->getPlayerLocationMock(
            $location,
            $allowEmbed,
            $autoPlay
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->expectToWriteElement($xmlWriter, 'video:player_loc', $location, [
            'allow_embed' => $allowEmbed,
            'autoplay' => $autoPlay,
        ]);

        $writer = new PlayerLocationWriter();

        $writer->write($playerLocation, $xmlWriter);
    }

    /**
     * @param string      $location
     * @param string|null $allowEmbed
     * @param string|null $autoPlay
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|PlayerLocationInterface
     */
    private function getPlayerLocationMock($location, $allowEmbed = null, $autoPlay = null)
    {
        $playerLocation = $this->getMockBuilder(PlayerLocationInterface::class)->getMock();

        $playerLocation
            ->expects($this->any())
            ->method('location')
            ->willReturn($location)
        ;

        $playerLocation
            ->expects($this->any())
            ->method('allowEmbed')
            ->willReturn($allowEmbed)
        ;

        $playerLocation
            ->expects($this->any())
            ->method('autoPlay')
            ->willReturn($autoPlay)
        ;

        return $playerLocation;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|XMLWriter
     */
    private function getXmlWriterMock()
    {
        return $this->getMockBuilder(XMLWriter::class)->getMock();
    }
}
