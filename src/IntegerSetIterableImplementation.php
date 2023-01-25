<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection;

use Smoren\PartialIntersection\Util\IteratorFactory;

class IntegerSetIterableImplementation
{
    /**
     * @param int $m
     * @param iterable<int> ...$sets
     * @return \Generator<int>
     */
    public static function partialIntersection(int $m, iterable ...$sets): \Generator
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

                if (!isset($usageMap[$value])) {
                    $usageMap[$value] = 0;
                }

                $usageMap[$value]++;

                if ($usageMap[$value] === $m) {
                    yield $value;
                }
            }
        }
    }
}
