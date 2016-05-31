<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\News;

/**
 * @link https://support.google.com/news/publisher/answer/74288?hl=en#exampleentry
 */
interface NewsInterface
{
    /**
     * Constants for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns:news';
    const XML_NAMESPACE_URI = 'http://www.google.com/schemas/sitemap-news/0.9';

    /**
     * Constants for access types.
     *
     * @link https://support.google.com/news/publisher/answer/93992
     */
    const ACCESS_SUBSCRIPTION = 'Subscription';
    const ACCESS_REGISTRATION = 'Registration';

    /**
     * Constants for genres.
     *
     * @link https://support.google.com/news/publisher/answer/93992
     */
    const GENRE_BLOG = 'Blog';
    const GENRE_OP_ED = 'OpEd';
    const GENRE_OPINION = 'Opinion';
    const GENRE_SATIRE = 'Satire';
    const GENRE_USER_GENERATED = 'UserGenerated';

    /**
     * Constant for maximum number of allowed stock tickers.
     *
     * @link https://support.google.com/news/publisher/answer/93992
     */
    const STOCK_TICKERS_MAX_COUNT = 5;

    /**
     * @return PublicationInterface
     */
    public function publication();

    /**
     * @return \DateTimeInterface
     */
    public function publicationDate();

    /**
     * @return string
     */
    public function title();

    /**
     * @return string|null
     */
    public function access();

    /**
     * @return array
     */
    public function genres();

    /**
     * @return array
     */
    public function keywords();

    /**
     * @return array
     */
    public function stockTickers();
}
