<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection;

use Smoren\PartialIntersection\Util\JustifyMultipleIterator;
use Smoren\PartialIntersection\Util\NoValueMonad;
use Smoren\PartialIntersection\Util\UsageMap;

class MultisetIterableImplementation
{
    /**
     * @template T
     *
     * @param bool $strict
     * @param int $m
     * @param iterable<T> ...$multisets
     *
     * @return \Generator<T>
     */
    public static function partialIntersection(bool $strict, int $m, iterable ...$multisets): \Generator
    {
        $usageMap = new UsageMap($strict);

        $multipleIterator = new JustifyMultipleIterator(...$multisets);

        foreach ($multipleIterator as $index => $values) {
            foreach ($values as $owner => $value) {
                if ($value instanceof NoValueMonad) {
                    continue;
                }

                $usageMap->addUsage($value, (string)$owner);

                if ($usageMap->getOwnersCount($value) === $m) {
                    yield $value;
                    $usageMap->deleteUsage($value);
                }
            }
        }
    }
}
