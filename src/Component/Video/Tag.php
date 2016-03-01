<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;
use InvalidArgumentException;

final class Tag implements TagInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     *
     * @throws InvalidArgumentException
     */
    public function __construct($content)
    {
        Assertion::string($content);

        $this->content = $content;
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->content;
    }
}
