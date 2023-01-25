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

We have **N** sets. An **M**-partial intersection (for **M** > 0) of these sets is a set whose elements
are contained in at least **M** initial sets.
