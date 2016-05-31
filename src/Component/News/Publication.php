<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\News;

use Assert\Assertion;

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
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($name, $language)
    {
        Assertion::string($name);
        Assertion::notBlank($name);
        Assertion::string($language);
        Assertion::notBlank($language);

        $this->name = $name;
        $this->language = $language;
    }

    public function name()
    {
        return $this->name;
    }

    public function language()
    {
        return $this->language;
    }
}
