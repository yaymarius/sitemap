<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\News;

use DateTime;
use InvalidArgumentException;

final class News implements NewsInterface
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
     * @var PublicationInterface
     */
    private $publication;

    /**
     * @var DateTime
     */
    private $publicationDate;

    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    private $access;

    /**
     * @var array
     */
    private $genres = [];

    /**
     * @var array
     */
    private $keywords = [];

    /**
     * @var array
     */
    private $stockTickers = [];

    /**
     * @param PublicationInterface $publication
     * @param DateTime             $publicationDate
     * @param string               $title
     * @param string|null          $access
     * @param array                $genres
     * @param array                $keywords
     * @param array                $stockTickers
     */
    public function __construct(
        PublicationInterface $publication,
        DateTime $publicationDate,
        $title,
        $access = null,
        array $genres = [],
        array $keywords = [],
        array $stockTickers = []
    ) {
        $this->publication = $publication;
        $this->publicationDate = $publicationDate;
        $this->title = $title;

        $this->setAccess($access);
        $this->setGenres($genres);

        $this->keywords = $keywords;

        $this->setStockTickers($stockTickers);
    }

    public function getPublication()
    {
        return $this->publication;
    }

    public function getPublicationDate()
    {
        return clone $this->publicationDate;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $access
     */
    private function setAccess($access = null)
    {
        if ($access === null) {
            return;
        }

        $allowedValues = [
            self::ACCESS_REGISTRATION,
            self::ACCESS_SUBSCRIPTION,
        ];

        if (!in_array($access, $allowedValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as one of "%s"',
                'access',
                implode('", "', $allowedValues)
            ));
        }

        $this->access = $access;
    }

    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param array $genres
     */
    private function setGenres(array $genres = [])
    {
        if (!count($genres)) {
            return;
        }

        $allowedValues = [
            self::GENRE_BLOG,
            self::GENRE_OP_ED,
            self::GENRE_OPINION,
            self::GENRE_SATIRE,
            self::GENRE_USER_GENERATED,
        ];

        $invalidValues = array_filter($genres, function ($genre) use ($allowedValues) {
            return !in_array($genre, $allowedValues, true);
        });

        if (count($invalidValues)) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as an array, and each element needs to be one of "%s"',
                'genres',
                implode('", "', $allowedValues)
            ));
        }

        $this->genres = $genres;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array $stockTickers
     */
    private function setStockTickers(array $stockTickers = [])
    {
        if (!count($stockTickers)) {
            return;
        }

        if (count($stockTickers) > self::STOCK_TICKERS_MAX_COUNT) {
            throw new InvalidArgumentException(sprintf(
                'Optional parameter "%s" needs to be specified as an array with at most "%s" elements',
                'stockTickers',
                self::STOCK_TICKERS_MAX_COUNT
            ));
        }

        $this->stockTickers = $stockTickers;
    }

    public function getStockTickers()
    {
        return $this->stockTickers;
    }
}
