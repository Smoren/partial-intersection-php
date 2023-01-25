<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection;

use Smoren\PartialIntersection\Util\IteratorFactory;
use Smoren\PartialIntersection\Util\UniqueExtractor;

class MixedSetIterableImplementation
{
    /**
     * @template T
     * @param bool $strict
     * @param int $m
     * @param iterable<T> ...$sets
     * @return \Generator<T>
     */
    public static function partialIntersection(bool $strict, int $m, iterable ...$sets): \Generator
    {
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY);

        foreach ($sets as $set) {
            $iterator->attachIterator(IteratorFactory::makeIterator($set));
        }

        $usageMap = [];

        foreach ($iterator as $values) {
            foreach ($values as $value) {
                if ($value === null) {
                    continue;
                }

                $hash = UniqueExtractor::getString($value, $strict);

                if (!isset($usageMap[$hash])) {
                    $usageMap[$hash] = 0;
                }

                $usageMap[$hash]++;

                if ($usageMap[$hash] === $m) {
                    yield $value;
                }
            }
        }
    }
}
