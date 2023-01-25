<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\PartialIntersection\SimpleIntSetImplementation;

class SimpleIntSetImplementationTest extends Unit
{
    /**
     * @dataProvider dataProviderForMain
     * @param array $sets
     * @param int $m
     * @param array $expected
     * @return void
     */
    public function testMain(array $sets, int $m, array $expected): void
    {
        // When
        $result = SimpleIntSetImplementation::partialIntersection($m, ...$sets);

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForMain(): array
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
}
