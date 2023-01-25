<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Util;

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
