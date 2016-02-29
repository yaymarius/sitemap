<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Refinery29\Sitemap\Test\Unit\Component;

use Refinery29\Test\Util\Faker\GeneratorTrait;

class DataProvider
{
    use GeneratorTrait;

    /**
     * @return \Generator
     */
    public function providerInvalidString()
    {
        $faker = $this->getFaker();

        $values = [
            null,
            $faker->boolean(),
            $faker->words,
            $faker->randomNumber(),
            $faker->randomFloat(),
            new \stdClass(),
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }
}
