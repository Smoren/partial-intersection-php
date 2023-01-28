<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

class IntegerSetArrayImplementationTest extends Unit
{
    /**
     * @dataProvider dataProviderForPartialIntersectionDemo
     * @dataProvider dataProviderForPartialIntersection
     *
     * @param array $sets
     * @param int $m
     * @param array $expected
     * @return void
     */
    public function testPartialIntersection(array $sets, int $m, array $expected): void
    {
        // When
        $result = IntegerSetArrayImplementation::partialIntersection($m, ...$sets);

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForPartialIntersectionDemo(): array
    {
        return [
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 10, 11],
                    [1, 2, 3, 12],
                    [1, 4, 13, 14],
                ],
                1,
                [1, 2, 3, 4, 5, 10, 11, 12, 13, 14],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 10, 11],
                    [1, 2, 3, 12],
                    [1, 4, 13, 14],
                ],
                2,
                [1, 2, 3, 4],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 10, 11],
                    [1, 2, 3, 12],
                    [1, 4, 13, 14],
                ],
                3,
                [1, 2],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 10, 11],
                    [1, 2, 3, 12],
                    [1, 4, 13, 14],
                ],
                4,
                [1],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 10, 11],
                    [1, 2, 3, 12],
                    [1, 4, 13, 14],
                ],
                5,
                [],
            ],
        ];
    }

    public function dataProviderForPartialIntersection(): array
    {
        return [
            [
                [],
                1,
                [],
            ],
            [
                [],
                2,
                [],
            ],
            [
                [
                    [],
                ],
                1,
                [],
            ],
            [
                [
                    [],
                ],
                2,
                [],
            ],
            [
                [
                    [],
                    [],
                ],
                1,
                [],
            ],
            [
                [
                    [],
                    [],
                ],
                2,
                [],
            ],
            [
                [
                    [],
                    [],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, 3],
                    [],
                ],
                1,
                [1, 2, 3],
            ],
            [
                [
                    [1, 2, 3],
                    [],
                ],
                2,
                [],
            ],
            [
                [
                    [1, 2, 3],
                    [],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, 3],
                ],
                1,
                [1, 2, 3],
            ],
            [
                [
                    [1, 2, 3],
                ],
                2,
                [],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                ],
                1,
                [1, 2, 3, 4],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                ],
                2,
                [2, 3],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [2, 3, 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                1,
                [1, 2, 3, 4, 5, 6, 7],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [2, 3, 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                2,
                [2, 3, 4, 5, 6],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [2, 3, 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                3,
                [3, 4, 5],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [2, 3, 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                4,
                [],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [5, 6, 7],
                ],
                1,
                [1, 2, 3, 4, 5, 6, 7],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [5, 6, 7],
                ],
                2,
                [2, 3],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [5, 6, 7],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, 3],
                    [2, 3, 4],
                    [5, 6, 7],
                ],
                4,
                [],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 3, 5, 7],
                    [3, 4, 5, 6, 7, 8, 9],
                ],
                1,
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                    [1, 3, 5, 7],
                    [3, 4, 5, 6, 7, 8, 9],
                ],
                2,
                [1, 3, 4, 5, 7],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForSymmetricDifference
     * @param array<array<int>> $sets
     * @param array<int> $expected
     * @return void
     */
    public function testSymmetricDifference(array $sets, array $expected): void
    {
        $symmetricDifference = IntegerSetArrayImplementation::symmetricDifference(...$sets);

        $this->assertEquals($expected, $symmetricDifference);
    }

    public function dataProviderForSymmetricDifference(): array
    {
        return [
            [
                [
                    [1, 2, 3, 4, 5],
                    [2, 3, 4, 5, 6],
                    [3, 4, 5, 6, 7],
                    [4, 5, 6, 7, 8],
                ],
                [1, 8],
            ],
        ];
    }
}
