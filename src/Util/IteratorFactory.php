<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Util;

/**
 * Based on IterTools PHP's IteratorFactory.
 * @see https://github.com/markrogoyski/itertools-php
 * @see https://github.com/markrogoyski/itertools-php/blob/main/src/Util/IteratorFactory.php
 */
class IteratorFactory
{
    /**
     * @param iterable<mixed> $iterable
     *
     * @return \Iterator<mixed>|\IteratorIterator<mixed>|\ArrayIterator<mixed>
     */
    public static function makeIterator(iterable $iterable): \Iterator
    {
        switch (true) {
            case $iterable instanceof \Iterator:
                return $iterable;
            case $iterable instanceof \Traversable:
                return new \IteratorIterator($iterable);
            default:
                return new \ArrayIterator($iterable);
        }
    }
}
