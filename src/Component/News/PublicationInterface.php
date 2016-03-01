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
interface PublicationInterface
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function language();
}
