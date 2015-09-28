<?php

namespace Refinery29\Sitemap\Component\News;

final class Publication implements PublicationInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $language;

    /**
     * @param string $name
     * @param string $language
     */
    public function __construct($name, $language)
    {
        $this->name = $name;
        $this->language = $language;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}
