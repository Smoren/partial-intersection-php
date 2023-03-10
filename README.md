# M-partial intersection of sets and multisets explanation

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Smoren/partial-intersection-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Smoren/partial-intersection-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/Smoren/partial-intersection-php/badge.svg?branch=master)](https://coveralls.io/github/Smoren/partial-intersection-php?branch=master)
![Build and test](https://github.com/Smoren/partial-intersection-php/actions/workflows/test_master.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Theory

### Definition

> An **M**-partial intersection (for **M > 0**) of **N** sets is a set elements
> in which are contained in at least **M** initial sets.

### Properties

For any **N** sets:

1. **1**-partial intersection is equivalent to the
   [union](https://en.wikipedia.org/wiki/Union_(set_theory)) of these sets.
2. **N**-partial intersection is equivalent to the
   [common (complete) intersection](https://en.wikipedia.org/wiki/Intersection_(set_theory)) of these sets.
3. For any **M > N** **M**-partial intersection always equals to the
   [empty set](https://en.wikipedia.org/wiki/Empty_set).

## Examples

* [Simple integer sets example](#Simple-integer-sets-example)
* [Iterable integer sets example](#Iterable-integer-sets-example)
* [Mixed iterable sets example](#Mixed-iterable-sets-example)
* [Multisets example](#Multisets-example)

### Simple integer sets example

Given: sets **A**, **B**, **C**, **D** (**N = 4**).

```php
$a = [1, 2, 3, 4, 5];
$b = [1, 2, 10, 11];
$c = [1, 2, 3, 12];
$d = [1, 4, 13, 14];
```

#### M = 1
It is equivalent to `A ∪ B ∪ C ∪ D`.

![image](docs/images/1.png)

```php
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(1, $a, $b, $c, $d);
// [1, 2, 3, 4, 5, 10, 11, 12, 13, 14]
```

#### M = 2
![image](docs/images/2.png)

```php
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(2, $a, $b, $c, $d);
// [1, 2, 3, 4]
```

#### M = 3

![image](docs/images/3.png)

```php
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(3, $a, $b, $c, $d);
// [1, 2]
```

#### M = 4 (M = N)
It is equivalent to `A ∩ B ∩ C ∩ D`.

![image](docs/images/4.png)

```php
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(4, $a, $b, $c, $d);
// [1]
```

#### M = 5 (M > N)
Equals to an empty set.

![image](docs/images/5.png)

```php
use Smoren\PartialIntersection\IntegerSetArrayImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(5, $a, $b, $c, $d);
// []
```

### Iterable integer sets example
```php
$a = [1, 2, 3, 4, 5];
$b = [1, 2, 10, 11];
$c = [1, 2, 3, 12];
$d = [1, 4, 13, 14];

use Smoren\PartialIntersection\IntegerSetIterableImplementation;

$r = IntegerSetArrayImplementation::partialIntersection(1, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// [1, 2, 3, 4, 5, 10, 11, 12, 13, 14]

$r = IntegerSetArrayImplementation::partialIntersection(2, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// [1, 2, 3, 4]

$r = IntegerSetArrayImplementation::partialIntersection(3, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// [1, 2]

$r = IntegerSetArrayImplementation::partialIntersection(4, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// [1]

$r = IntegerSetArrayImplementation::partialIntersection(5, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// []
```

### Mixed iterable sets example
```php
$a = ['1', 2, 3, 4, 5];
$b = ['1', 2, 10, 11];
$c = ['1', 2, 3, 12];
$d = ['1', 4, 13, 14];

use Smoren\PartialIntersection\MixedSetIterableImplementation;

$r = MixedSetIterableImplementation::partialIntersection(true, 1, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// ['1', 2, 3, 4, 5, 10, 11, 12, 13, 14]

$r = MixedSetIterableImplementation::partialIntersection(true, 2, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// ['1', 2, 3, 4]

$r = MixedSetIterableImplementation::partialIntersection(true, 3, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// ['1', 2]

$r = MixedSetIterableImplementation::partialIntersection(true, 4, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// ['1']

$r = IntegerSetArrayImplementation::partialIntersection(true, 5, $a, $b, $c, $d);
print_r(iterator_to_array($r));
// []
```

### Multisets example

*Note: If input collections contains duplicate items, then
[multiset](https://en.wikipedia.org/wiki/Multiset) intersection rules apply.*

```php
$a = [1, 1, 1, 1, 1];
$b = [1, 2, 3, 4, 5, 1, 2, 3, 4, 5];
$c = [5, 5, 5, 5, 5, 1, 5, 5, 1];

use Smoren\PartialIntersection\MultisetIterableImplementation;

$r = MultisetIterableImplementation::partialIntersection(true, 1, $a, $b, $c);
print_r(iterator_to_array($r));
// [1, 1, 1, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 5, 5, 5, 5, 5]

$r = MultisetIterableImplementation::partialIntersection(true, 2, $a, $b, $c);
print_r(iterator_to_array($r));
// [1, 1, 5, 5]

$r = MultisetIterableImplementation::partialIntersection(true, 3, $a, $b, $c);
print_r(iterator_to_array($r));
// [1, 1]

$r = MultisetIterableImplementation::partialIntersection(true, 4, $a, $b, $c);
print_r(iterator_to_array($r));
// []
```

## Unit testing
```
composer install
composer test-init
composer test
```
