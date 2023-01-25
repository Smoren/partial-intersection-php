<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Tests\Unit\Fixture;

/**
 * Based on IterTools PHP's IteratorAggregateFixture.
 * @see https://github.com/markrogoyski/itertools-php
 * @see https://github.com/markrogoyski/itertools-php/blob/main/tests/Fixture/IteratorAggregateFixture.php
 */
class IteratorAggregateFixture implements \IteratorAggregate
{
    private array $values;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->values);
    }
}
