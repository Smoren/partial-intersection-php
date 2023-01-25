<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Tests\Unit\Fixture;

/**
 * Based on IterTools PHP's ArrayIteratorFixture.
 * @see https://github.com/markrogoyski/itertools-php
 * @see https://github.com/markrogoyski/itertools-php/blob/main/tests/Fixture/ArrayIteratorFixture.php
 */
class ArrayIteratorFixture implements \Iterator
{
    private array $values;
    private int $i;

    public function __construct(array $values)
    {
        $this->values = $values;
        $this->i      = 0;
    }

    public function rewind(): void
    {
        $this->i = 0;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->values[$this->i];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->i;
    }

    public function next(): void
    {
        ++$this->i;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return array_key_exists($this->i, $this->values);
    }
}
