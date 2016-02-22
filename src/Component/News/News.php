<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Component\News;

use Assert\Assertion;
use DateTime;

final class News implements NewsInterface
{
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
        $choices = [
            NewsInterface::ACCESS_REGISTRATION,
            NewsInterface::ACCESS_SUBSCRIPTION,
        ];

        Assertion::nullOrChoice($access, $choices);

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
        $choices = [
            NewsInterface::GENRE_BLOG,
            NewsInterface::GENRE_OP_ED,
            NewsInterface::GENRE_OPINION,
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_USER_GENERATED,
        ];

        Assertion::allChoice($genres, $choices);

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
        Assertion::lessOrEqualThan(count($stockTickers), NewsInterface::STOCK_TICKERS_MAX_COUNT);

        $this->stockTickers = $stockTickers;
    }

    public function getStockTickers()
    {
        return $this->stockTickers;
    }
}
