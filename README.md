# M-partial intersection of sets and multisets explanation

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Smoren/partial-intersection-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Smoren/partial-intersection-php/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/Smoren/partial-intersection-php/badge.svg?branch=master)](https://coveralls.io/github/Smoren/partial-intersection-php?branch=master)
![Build and test](https://github.com/Smoren/partial-intersection-php/actions/workflows/test_master.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

### Unit testing
```
composer install
composer test-init
composer test
```

### Theory

#### Definition

We have **N** sets. An **M**-partial intersection (for **M > 0**) of these sets is a set whose elements
are contained in at least **M** initial sets.

#### Simple integer sets example

Given: sets **A**, **B**, **C**, **D** (**N = 4**).

```php
$a = [1, 2, 3, 4, 5];
$b = [1, 2, 10, 11];
$c = [1, 2, 3, 12];
$d = [1, 4, 13, 14];
```

##### M = 1

It is equivalent to classical union operation (for any **N**).

![image](docs/images/1.png)

```php
use Smoren\PartialIntersection\SimpleIntSetImplementation;

$r = SimpleIntSetImplementation::partialIntersection(1, $a, $b, $c, $d);
// [1, 2, 3, 4, 5, 10, 11, 12, 13, 14]
```

##### M = 2
It is equivalent to `union($a, $b, $c, $d) - symmetricDifference($a, $b, $c, $d)` (for any N).

![image](docs/images/2.png)

```php
use Smoren\PartialIntersection\SimpleIntSetImplementation;

$r = SimpleIntSetImplementation::partialIntersection(2, $a, $b, $c, $d);
// [1, 2, 3, 4]
```

##### M = 3

![image](docs/images/3.png)

```php
use Smoren\PartialIntersection\SimpleIntSetImplementation;

$r = SimpleIntSetImplementation::partialIntersection(3, $a, $b, $c, $d);
// [1, 2]
```

##### M = 4 (M = N)
It is equivalent to classical (complete) intersection operation (for any **N**).

![image](docs/images/4.png)

```php
use Smoren\PartialIntersection\SimpleIntSetImplementation;

$r = SimpleIntSetImplementation::partialIntersection(4, $a, $b, $c, $d);
// [1]
```

##### M = 5 (M > N)
It is equivalent to empty set (for any **M**, **N**: **M > N**)

![image](docs/images/5.png)

```php
use Smoren\PartialIntersection\SimpleIntSetImplementation;

$r = SimpleIntSetImplementation::partialIntersection(5, $a, $b, $c, $d);
// []
```
