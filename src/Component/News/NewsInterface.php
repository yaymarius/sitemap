<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\News;

use DateTime;

/**
 * @link https://support.google.com/news/publisher/answer/74288?hl=en#exampleentry
 */
interface NewsInterface
{
    /**
     * @return PublicationInterface
     */
    public function getPublication();

    /**
     * @return DateTime
     */
    public function getPublicationDate();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getAccess();

    /**
     * @return array
     */
    public function getGenres();

    /**
     * @return array
     */
    public function getKeywords();

    /**
     * @return array
     */
    public function getStockTickers();
}
