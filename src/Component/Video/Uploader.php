<?php

namespace Refinery29\Sitemap\Component\Video;

final class Uploader implements UploaderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $info;

    /**
     * @param string      $name
     * @param string|null $info
     */
    public function __construct($name, $info = null)
    {
        $this->name = $name;
        $this->info = $info;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getInfo()
    {
        return $this->info;
    }
}
