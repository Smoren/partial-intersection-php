<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection;

class IntegerSetArrayImplementation
{
    /**
     * @param int $m
     * @param array<int> ...$sets
     *
     * @return array<int>
     */
    public static function partialIntersection(int $m, array ...$sets): array
    {
        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY);

        foreach ($sets as $set) {
            $iterator->attachIterator(new \ArrayIterator($set));
        }

        $usageMap = [];
        $result = [];

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
                    $result[] = $value;
                }
            }
        }

        sort($result);

        return $result;
    }

    /**
     * Symmetric difference of multiple sets.
     *
     * @param array<int> ...$sets
     * @return array
     */
    public static function symmetricDifference(array ...$sets): array
    {
        $union = array_values(array_unique(array_merge(...$sets)));
        $twoPartInt = self::partialIntersection(2, ...$sets);

        return array_values(array_diff($union, $twoPartInt));
    }
}
