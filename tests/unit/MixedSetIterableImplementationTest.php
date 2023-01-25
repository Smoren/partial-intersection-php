<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\PartialIntersection\MixedSetIterableImplementation;
use Smoren\PartialIntersection\Tests\Unit\Fixture\ArrayIteratorFixture;
use Smoren\PartialIntersection\Tests\Unit\Fixture\GeneratorFixture;
use Smoren\PartialIntersection\Tests\Unit\Fixture\IteratorAggregateFixture;

class MixedSetIterableImplementationTest extends Unit
{
    /**
     * @dataProvider dataProviderForDemo
     * @dataProvider dataProviderForArrays
     * @dataProvider dataProviderForGenerators
     * @dataProvider dataProviderForIterators
     * @dataProvider dataProviderForTraversables
     *
     * @param array $sets
     * @param int $m
     * @param array $expected
     * @return void
     */
    public function testStrict(array $sets, int $m, array $expected): void
    {
        // Given
        $result = [];

        // When
        foreach (MixedSetIterableImplementation::partialIntersection(true, $m, ...$sets) as $value) {
            $result[] = $value;
        }
        sort($result);
        sort($expected);

        // Then
        $this->assertEquals($expected, $result);
    }

    public function dataProviderForDemo(): array
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

    public function dataProviderForArrays(): array
    {
        $gen = fn (array $data) => GeneratorFixture::getGenerator($data);
        $res = fn () => fopen('php://input', 'r');
        $clos = fn () => (fn () => 1);

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
                    [1.1, 2.1, 3.1],
                    [],
                ],
                1,
                [1.1, 2.1, 3.1],
            ],
            [
                [
                    [1.1, 2.1, 3.1],
                    [],
                ],
                2,
                [],
            ],
            [
                [
                    [1.1, 2.1, 3.1],
                    [],
                ],
                3,
                [],
            ],
            [
                [
                    ['1', '2', '3'],
                    [],
                ],
                1,
                ['1', '2', '3'],
            ],
            [
                [
                    ['1', '2', '3'],
                    [],
                ],
                2,
                [],
            ],
            [
                [
                    ['1', '2', '3'],
                    [],
                ],
                3,
                [],
            ],
            [
                [
                    [true, false],
                ],
                1,
                [false, true],
            ],
            [
                [
                    [true, false],
                ],
                2,
                [],
            ],
            [
                [
                    [true, false],
                    [false],
                ],
                1,
                [false, true],
            ],
            [
                [
                    [true, false],
                    [false],
                ],
                2,
                [false],
            ],
            [
                [
                    [true, false],
                    [false],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, 1.2, 1.3, 'a', 'b', true, false],
                    [1, 3, 1.2, 1.5, 'a', 'c', true],
                ],
                1,
                [1, 2, 3, 1.2, 1.3, 1.5, 'a', 'b', 'c', true, false],
            ],
            [
                [
                    [1, 2, 1.2, 1.3, 'a', 'b', true, false],
                    [1, 3, 1.2, 1.5, 'a', 'c', true],
                ],
                2,
                [1, 1.2, 'a', true],
            ],
            [
                [
                    [1, 2, 1.2, 1.3, 'a', 'b', true, false],
                    [1, 3, 1.2, 1.5, 'a', 'c', true],
                ],
                3,
                [],
            ],
            [
                [
                    [1, 2, '3', 4, 5],
                    [2, '3', 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                1,
                [1, 2, '3', 3, 4, 5, 6, 7],
            ],
            [
                [
                    [1, 2, '3', 4, 5],
                    [2, '3', 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                2,
                [2, 3, 4, 5, 6],
            ],
            [
                [
                    [1, 2, '3', 4, 5],
                    [2, '3', 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                3,
                [4, 5],
            ],
            [
                [
                    [1, 2, '3', 4, 5],
                    [2, '3', 4, 5, 6],
                    [3, 4, 5, 6, 7],
                ],
                4,
                [],
            ],
            [
                [
                    [[1], [2], [3], [4], [5]],
                    [[2], [3], [4], [5], [6]],
                    [[3], [4], [5], [6], [7]],
                ],
                1,
                [[1], [2], [3], [4], [5], [6], [7]],
            ],
            [
                [
                    [[1], [2], [3], [4], [5]],
                    [[2], [3], [4], [5], [6]],
                    [[3], [4], [5], [6], [7]],
                ],
                2,
                [[2], [3], [4], [5], [6]],
            ],
            [
                [
                    [[1], [2], [3], [4], [5]],
                    [[2], [3], [4], [5], [6]],
                    [[3], [4], [5], [6], [7]],
                ],
                3,
                [[3], [4], [5]],
            ],
            [
                [
                    [[1], [2], [3], [4], [5]],
                    [[2], [3], [4], [5], [6]],
                    [[3], [4], [5], [6], [7]],
                ],
                4,
                [],
            ],
            [
                [
                    [$o1 = (object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]],
                    [$o2, $o3, $o4, $o5, $o6 = (object)[6]],
                    [$o3, $o4, $o5, $o6, $o7 = (object)[7]],
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    [(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]],
                    [$o2, $o3, $o4, $o5, $o6 = (object)[6]],
                    [$o3, $o4, $o5, $o6, (object)[7]],
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    [(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]],
                    [$o2, $o3, $o4, $o5, $o6 = (object)[6]],
                    [$o3, $o4, $o5, $o6, (object)[7]],
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    [(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]],
                    [$o2, $o3, $o4, $o5, $o6 = (object)[6]],
                    [$o3, $o4, $o5, $o6, (object)[7]],
                ],
                4,
                [],
            ],
            [
                [
                    [$o1 = $gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])],
                    [$o2, $o3, $o4, $o5, $o6 = $gen([])],
                    [$o3, $o4, $o5, $o6, $o7 = $gen([])],
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    [$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])],
                    [$o2, $o3, $o4, $o5, $o6 = $gen([])],
                    [$o3, $o4, $o5, $o6, $gen([])],
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    [$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])],
                    [$o2, $o3, $o4, $o5, $o6 = $gen([])],
                    [$o3, $o4, $o5, $o6, $gen([])],
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    [$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])],
                    [$o2, $o3, $o4, $o5, $o6 = $gen([])],
                    [$o3, $o4, $o5, $o6, $gen([])],
                ],
                4,
                [],
            ],
            [
                [
                    [$o1 = $res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()],
                    [$o2, $o3, $o4, $o5, $o6 = $res()],
                    [$o3, $o4, $o5, $o6, $o7 = $res()],
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    [$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()],
                    [$o2, $o3, $o4, $o5, $o6 = $res()],
                    [$o3, $o4, $o5, $o6, $res()],
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    [$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()],
                    [$o2, $o3, $o4, $o5, $o6 = $res()],
                    [$o3, $o4, $o5, $o6, $res()],
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    [$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()],
                    [$o2, $o3, $o4, $o5, $o6 = $res()],
                    [$o3, $o4, $o5, $o6, $res()],
                ],
                4,
                [],
            ],
            [
                [
                    [$o1 = $clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()],
                    [$o2, $o3, $o4, $o5, $o6 = $clos()],
                    [$o3, $o4, $o5, $o6, $o7 = $clos()],
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    [$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()],
                    [$o2, $o3, $o4, $o5, $o6 = $clos()],
                    [$o3, $o4, $o5, $o6, $clos()],
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    [$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()],
                    [$o2, $o3, $o4, $o5, $o6 = $clos()],
                    [$o3, $o4, $o5, $o6, $clos()],
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    [$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()],
                    [$o2, $o3, $o4, $o5, $o6 = $clos()],
                    [$o3, $o4, $o5, $o6, $clos()],
                ],
                4,
                [],
            ],
        ];
    }

    public function dataProviderForGenerators(): array
    {
        $gen = fn (array $data) => GeneratorFixture::getGenerator($data);
        $res = fn () => fopen('php://input', 'r');
        $clos = fn () => (fn () => 1);

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
                    $gen([]),
                ],
                1,
                [],
            ],
            [
                [
                    $gen([]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen([]),
                    $gen([]),
                ],
                1,
                [],
            ],
            [
                [
                    $gen([]),
                    $gen([]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen([]),
                    $gen([]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen([1, 2, 3]),
                    $gen([]),
                ],
                1,
                [1, 2, 3],
            ],
            [
                [
                    $gen([1, 2, 3]),
                    $gen([]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen([1, 2, 3]),
                    $gen([]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen([1.1, 2.1, 3.1]),
                    $gen([]),
                ],
                1,
                [1.1, 2.1, 3.1],
            ],
            [
                [
                    $gen([1.1, 2.1, 3.1]),
                    $gen([]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen([1.1, 2.1, 3.1]),
                    $gen([]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen(['1', '2', '3']),
                    $gen([]),
                ],
                1,
                ['1', '2', '3'],
            ],
            [
                [
                    $gen(['1', '2', '3']),
                    $gen([]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen(['1', '2', '3']),
                    $gen([]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen([true, false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $gen([true, false]),
                ],
                2,
                [],
            ],
            [
                [
                    $gen([true, false]),
                    $gen([false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $gen([true, false]),
                    $gen([false]),
                ],
                2,
                [false],
            ],
            [
                [
                    $gen([true, false]),
                    $gen([false]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $gen([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                1,
                [1, 2, 3, 1.2, 1.3, 1.5, 'a', 'b', 'c', true, false],
            ],
            [
                [
                    $gen([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $gen([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                2,
                [1, 1.2, 'a', true],
            ],
            [
                [
                    $gen([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $gen([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                3,
                [],
            ],
            [
                [
                    $gen([1, 2, '3', 4, 5]),
                    $gen([2, '3', 4, 5, 6]),
                    $gen([3, 4, 5, 6, 7]),
                ],
                1,
                [1, 2, '3', 3, 4, 5, 6, 7],
            ],
            [
                [
                    $gen([1, 2, '3', 4, 5]),
                    $gen([2, '3', 4, 5, 6]),
                    $gen([3, 4, 5, 6, 7]),
                ],
                2,
                [2, 3, 4, 5, 6],
            ],
            [
                [
                    $gen([1, 2, '3', 4, 5]),
                    $gen([2, '3', 4, 5, 6]),
                    $gen([3, 4, 5, 6, 7]),
                ],
                3,
                [4, 5],
            ],
            [
                [
                    $gen([1, 2, '3', 4, 5]),
                    $gen([2, '3', 4, 5, 6]),
                    $gen([3, 4, 5, 6, 7]),
                ],
                4,
                [],
            ],
            [
                [
                    $gen([[1], [2], [3], [4], [5]]),
                    $gen([[2], [3], [4], [5], [6]]),
                    $gen([[3], [4], [5], [6], [7]]),
                ],
                1,
                [[1], [2], [3], [4], [5], [6], [7]],
            ],
            [
                [
                    $gen([[1], [2], [3], [4], [5]]),
                    $gen([[2], [3], [4], [5], [6]]),
                    $gen([[3], [4], [5], [6], [7]]),
                ],
                2,
                [[2], [3], [4], [5], [6]],
            ],
            [
                [
                    $gen([[1], [2], [3], [4], [5]]),
                    $gen([[2], [3], [4], [5], [6]]),
                    $gen([[3], [4], [5], [6], [7]]),
                ],
                3,
                [[3], [4], [5]],
            ],
            [
                [
                    $gen([[1], [2], [3], [4], [5]]),
                    $gen([[2], [3], [4], [5], [6]]),
                    $gen([[3], [4], [5], [6], [7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $gen([$o1 = (object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $gen([$o3, $o4, $o5, $o6, $o7 = (object)[7]]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $gen([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $gen([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $gen([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $gen([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $gen([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $gen([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $gen([$o1 = $gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $gen([$o3, $o4, $o5, $o6, $o7 = $gen([])]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $gen([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $gen([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $gen([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $gen([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $gen([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $gen([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                4,
                [],
            ],
            [
                [
                    $gen([$o1 = $res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $gen([$o3, $o4, $o5, $o6, $o7 = $res()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $gen([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $gen([$o3, $o4, $o5, $o6, $res()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $gen([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $gen([$o3, $o4, $o5, $o6, $res()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $gen([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $gen([$o3, $o4, $o5, $o6, $res()]),
                ],
                4,
                [],
            ],
            [
                [
                    $gen([$o1 = $clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $gen([$o3, $o4, $o5, $o6, $o7 = $clos()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $gen([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $gen([$o3, $o4, $o5, $o6, $clos()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $gen([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $gen([$o3, $o4, $o5, $o6, $clos()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $gen([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $gen([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $gen([$o3, $o4, $o5, $o6, $clos()]),
                ],
                4,
                [],
            ],
        ];
    }

    public function dataProviderForIterators(): array
    {
        $iter = fn (array $data) => new ArrayIteratorFixture($data);
        $gen = fn (array $data) => GeneratorFixture::getGenerator($data);
        $res = fn () => fopen('php://input', 'r');
        $clos = fn () => (fn () => 1);

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
                    $iter([]),
                ],
                1,
                [],
            ],
            [
                [
                    $iter([]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter([]),
                    $iter([]),
                ],
                1,
                [],
            ],
            [
                [
                    $iter([]),
                    $iter([]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter([]),
                    $iter([]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter([1, 2, 3]),
                    $iter([]),
                ],
                1,
                [1, 2, 3],
            ],
            [
                [
                    $iter([1, 2, 3]),
                    $iter([]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter([1, 2, 3]),
                    $iter([]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter([1.1, 2.1, 3.1]),
                    $iter([]),
                ],
                1,
                [1.1, 2.1, 3.1],
            ],
            [
                [
                    $iter([1.1, 2.1, 3.1]),
                    $iter([]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter([1.1, 2.1, 3.1]),
                    $iter([]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter(['1', '2', '3']),
                    $iter([]),
                ],
                1,
                ['1', '2', '3'],
            ],
            [
                [
                    $iter(['1', '2', '3']),
                    $iter([]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter(['1', '2', '3']),
                    $iter([]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter([true, false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $iter([true, false]),
                ],
                2,
                [],
            ],
            [
                [
                    $iter([true, false]),
                    $iter([false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $iter([true, false]),
                    $iter([false]),
                ],
                2,
                [false],
            ],
            [
                [
                    $iter([true, false]),
                    $iter([false]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $iter([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                1,
                [1, 2, 3, 1.2, 1.3, 1.5, 'a', 'b', 'c', true, false],
            ],
            [
                [
                    $iter([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $iter([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                2,
                [1, 1.2, 'a', true],
            ],
            [
                [
                    $iter([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $iter([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                3,
                [],
            ],
            [
                [
                    $iter([1, 2, '3', 4, 5]),
                    $iter([2, '3', 4, 5, 6]),
                    $iter([3, 4, 5, 6, 7]),
                ],
                1,
                [1, 2, '3', 3, 4, 5, 6, 7],
            ],
            [
                [
                    $iter([1, 2, '3', 4, 5]),
                    $iter([2, '3', 4, 5, 6]),
                    $iter([3, 4, 5, 6, 7]),
                ],
                2,
                [2, 3, 4, 5, 6],
            ],
            [
                [
                    $iter([1, 2, '3', 4, 5]),
                    $iter([2, '3', 4, 5, 6]),
                    $iter([3, 4, 5, 6, 7]),
                ],
                3,
                [4, 5],
            ],
            [
                [
                    $iter([1, 2, '3', 4, 5]),
                    $iter([2, '3', 4, 5, 6]),
                    $iter([3, 4, 5, 6, 7]),
                ],
                4,
                [],
            ],
            [
                [
                    $iter([[1], [2], [3], [4], [5]]),
                    $iter([[2], [3], [4], [5], [6]]),
                    $iter([[3], [4], [5], [6], [7]]),
                ],
                1,
                [[1], [2], [3], [4], [5], [6], [7]],
            ],
            [
                [
                    $iter([[1], [2], [3], [4], [5]]),
                    $iter([[2], [3], [4], [5], [6]]),
                    $iter([[3], [4], [5], [6], [7]]),
                ],
                2,
                [[2], [3], [4], [5], [6]],
            ],
            [
                [
                    $iter([[1], [2], [3], [4], [5]]),
                    $iter([[2], [3], [4], [5], [6]]),
                    $iter([[3], [4], [5], [6], [7]]),
                ],
                3,
                [[3], [4], [5]],
            ],
            [
                [
                    $iter([[1], [2], [3], [4], [5]]),
                    $iter([[2], [3], [4], [5], [6]]),
                    $iter([[3], [4], [5], [6], [7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $iter([$o1 = (object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $iter([$o3, $o4, $o5, $o6, $o7 = (object)[7]]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $iter([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $iter([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $iter([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $iter([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $iter([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $iter([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $iter([$o1 = $gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $iter([$o3, $o4, $o5, $o6, $o7 = $gen([])]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $iter([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $iter([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $iter([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $iter([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $iter([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $iter([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                4,
                [],
            ],
            [
                [
                    $iter([$o1 = $res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $iter([$o3, $o4, $o5, $o6, $o7 = $res()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $iter([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $iter([$o3, $o4, $o5, $o6, $res()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $iter([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $iter([$o3, $o4, $o5, $o6, $res()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $iter([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $iter([$o3, $o4, $o5, $o6, $res()]),
                ],
                4,
                [],
            ],
            [
                [
                    $iter([$o1 = $clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $iter([$o3, $o4, $o5, $o6, $o7 = $clos()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $iter([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $iter([$o3, $o4, $o5, $o6, $clos()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $iter([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $iter([$o3, $o4, $o5, $o6, $clos()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $iter([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $iter([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $iter([$o3, $o4, $o5, $o6, $clos()]),
                ],
                4,
                [],
            ],
        ];
    }

    public function dataProviderForTraversables(): array
    {
        $trav = fn (array $data) => new IteratorAggregateFixture($data);
        $gen = fn (array $data) => GeneratorFixture::getGenerator($data);
        $res = fn () => fopen('php://input', 'r');
        $clos = fn () => (fn () => 1);

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
                    $trav([]),
                ],
                1,
                [],
            ],
            [
                [
                    $trav([]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav([]),
                    $trav([]),
                ],
                1,
                [],
            ],
            [
                [
                    $trav([]),
                    $trav([]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav([]),
                    $trav([]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav([1, 2, 3]),
                    $trav([]),
                ],
                1,
                [1, 2, 3],
            ],
            [
                [
                    $trav([1, 2, 3]),
                    $trav([]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav([1, 2, 3]),
                    $trav([]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav([1.1, 2.1, 3.1]),
                    $trav([]),
                ],
                1,
                [1.1, 2.1, 3.1],
            ],
            [
                [
                    $trav([1.1, 2.1, 3.1]),
                    $trav([]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav([1.1, 2.1, 3.1]),
                    $trav([]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav(['1', '2', '3']),
                    $trav([]),
                ],
                1,
                ['1', '2', '3'],
            ],
            [
                [
                    $trav(['1', '2', '3']),
                    $trav([]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav(['1', '2', '3']),
                    $trav([]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav([true, false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $trav([true, false]),
                ],
                2,
                [],
            ],
            [
                [
                    $trav([true, false]),
                    $trav([false]),
                ],
                1,
                [false, true],
            ],
            [
                [
                    $trav([true, false]),
                    $trav([false]),
                ],
                2,
                [false],
            ],
            [
                [
                    $trav([true, false]),
                    $trav([false]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $trav([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                1,
                [1, 2, 3, 1.2, 1.3, 1.5, 'a', 'b', 'c', true, false],
            ],
            [
                [
                    $trav([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $trav([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                2,
                [1, 1.2, 'a', true],
            ],
            [
                [
                    $trav([1, 2, 1.2, 1.3, 'a', 'b', true, false]),
                    $trav([1, 3, 1.2, 1.5, 'a', 'c', true]),
                ],
                3,
                [],
            ],
            [
                [
                    $trav([1, 2, '3', 4, 5]),
                    $trav([2, '3', 4, 5, 6]),
                    $trav([3, 4, 5, 6, 7]),
                ],
                1,
                [1, 2, '3', 3, 4, 5, 6, 7],
            ],
            [
                [
                    $trav([1, 2, '3', 4, 5]),
                    $trav([2, '3', 4, 5, 6]),
                    $trav([3, 4, 5, 6, 7]),
                ],
                2,
                [2, 3, 4, 5, 6],
            ],
            [
                [
                    $trav([1, 2, '3', 4, 5]),
                    $trav([2, '3', 4, 5, 6]),
                    $trav([3, 4, 5, 6, 7]),
                ],
                3,
                [4, 5],
            ],
            [
                [
                    $trav([1, 2, '3', 4, 5]),
                    $trav([2, '3', 4, 5, 6]),
                    $trav([3, 4, 5, 6, 7]),
                ],
                4,
                [],
            ],
            [
                [
                    $trav([[1], [2], [3], [4], [5]]),
                    $trav([[2], [3], [4], [5], [6]]),
                    $trav([[3], [4], [5], [6], [7]]),
                ],
                1,
                [[1], [2], [3], [4], [5], [6], [7]],
            ],
            [
                [
                    $trav([[1], [2], [3], [4], [5]]),
                    $trav([[2], [3], [4], [5], [6]]),
                    $trav([[3], [4], [5], [6], [7]]),
                ],
                2,
                [[2], [3], [4], [5], [6]],
            ],
            [
                [
                    $trav([[1], [2], [3], [4], [5]]),
                    $trav([[2], [3], [4], [5], [6]]),
                    $trav([[3], [4], [5], [6], [7]]),
                ],
                3,
                [[3], [4], [5]],
            ],
            [
                [
                    $trav([[1], [2], [3], [4], [5]]),
                    $trav([[2], [3], [4], [5], [6]]),
                    $trav([[3], [4], [5], [6], [7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $trav([$o1 = (object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $trav([$o3, $o4, $o5, $o6, $o7 = (object)[7]]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $trav([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $trav([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $trav([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $trav([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $trav([(object)[1], $o2 = (object)[2], $o3 = (object)[3], $o4 = (object)[4], $o5 = (object)[5]]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = (object)[6]]),
                    $trav([$o3, $o4, $o5, $o6, (object)[7]]),
                ],
                4,
                [],
            ],
            [
                [
                    $trav([$o1 = $gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $trav([$o3, $o4, $o5, $o6, $o7 = $gen([])]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $trav([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $trav([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $trav([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $trav([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $trav([$gen([]), $o2 = $gen([]), $o3 = $gen([]), $o4 = $gen([]), $o5 = $gen([])]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $gen([])]),
                    $trav([$o3, $o4, $o5, $o6, $gen([])]),
                ],
                4,
                [],
            ],
            [
                [
                    $trav([$o1 = $res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $trav([$o3, $o4, $o5, $o6, $o7 = $res()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $trav([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $trav([$o3, $o4, $o5, $o6, $res()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $trav([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $trav([$o3, $o4, $o5, $o6, $res()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $trav([$res(), $o2 = $res(), $o3 = $res(), $o4 = $res(), $o5 = $res()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $res()]),
                    $trav([$o3, $o4, $o5, $o6, $res()]),
                ],
                4,
                [],
            ],
            [
                [
                    $trav([$o1 = $clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $trav([$o3, $o4, $o5, $o6, $o7 = $clos()]),
                ],
                1,
                [$o1, $o2, $o3, $o4, $o5, $o6, $o7],
            ],
            [
                [
                    $trav([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $trav([$o3, $o4, $o5, $o6, $clos()]),
                ],
                2,
                [$o2, $o3, $o4, $o5, $o6],
            ],
            [
                [
                    $trav([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $trav([$o3, $o4, $o5, $o6, $clos()]),
                ],
                3,
                [$o3, $o4, $o5],
            ],
            [
                [
                    $trav([$clos(), $o2 = $clos(), $o3 = $clos(), $o4 = $clos(), $o5 = $clos()]),
                    $trav([$o2, $o3, $o4, $o5, $o6 = $clos()]),
                    $trav([$o3, $o4, $o5, $o6, $clos()]),
                ],
                4,
                [],
            ],
        ];
    }
}
