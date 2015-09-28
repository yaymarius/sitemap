<?php

namespace Refinery29\Sitemap\Component\News;

/**
 * @link https://support.google.com/news/publisher/answer/74288?hl=en#exampleentry
 */
interface PublicationInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLanguage();
}
