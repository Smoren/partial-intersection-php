<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Tests\Unit\Fixture;

/**
 * Based on IterTools PHP's GeneratorFixture.
 * @see https://github.com/markrogoyski/itertools-php
 * @see https://github.com/markrogoyski/itertools-php/blob/main/tests/Fixture/GeneratorFixture.php
 */
class GeneratorFixture
{
    public static function getGenerator(array $values): \Generator
    {
        foreach ($values as $value) {
            yield $value;
        }
    }
}
