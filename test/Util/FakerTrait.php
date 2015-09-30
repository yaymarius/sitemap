<?php

namespace Refinery29\Sitemap\Test\Util;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    /**
     * @return Generator
     */
    protected function getFaker()
    {
        static $faker;

        if ($faker === null) {
            $faker = Factory::create('en_US');
            $faker->seed(9000);
        }

        return $faker;
    }
}
