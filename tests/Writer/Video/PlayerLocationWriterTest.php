<?php

namespace Refinery29\Sitemap\Test\Writer\Video;

use Refinery29\Sitemap\Component\Video\PlayerLocation;
use Refinery29\Sitemap\Component\Video\PlayerLocationInterface;
use Refinery29\Sitemap\Test\Writer\AbstractTestCase;
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

        $this->writesElement($xmlWriter, 'video:player_loc', $location);

        $writer = new PlayerLocationWriter();

        $writer->write($xmlWriter, $playerLocation);
    }

    public function testWriteAdvancedPlayerLocation()
    {
        $faker = $this->getFaker();

        $location = $faker->url;
        $allowEmbed = $faker->randomElement([
            PlayerLocation::ALLOW_EMBED_NO,
            PlayerLocation::ALLOW_EMBED_YES,
        ]);
        $autoPlay = 'play=yes';

        $playerLocation = $this->getPlayerLocationMock(
            $location,
            $allowEmbed,
            $autoPlay
        );

        $xmlWriter = $this->getXmlWriterMock();

        $this->writesElement($xmlWriter, 'video:player_loc', $location, [
            'allow_embed' => $allowEmbed,
            'autoplay' => $autoPlay,
        ]);

        $writer = new PlayerLocationWriter();

        $writer->write($xmlWriter, $playerLocation);
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
            ->method('getLocation')
            ->willReturn($location)
        ;

        $playerLocation
            ->expects($this->any())
            ->method('getAllowEmbed')
            ->willReturn($allowEmbed)
        ;

        $playerLocation
            ->expects($this->any())
            ->method('getAutoPlay')
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
