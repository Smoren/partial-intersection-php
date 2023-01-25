<?php

namespace Smoren\PartialIntersection\Util;

/**
 * Based on IterTools PHP's IteratorFactory.
 * @see https://github.com/markrogoyski/itertools-php
 * @see https://github.com/markrogoyski/itertools-php/blob/main/src/Util/NoValueMonad.php
 */
class NoValueMonad
{
    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }
}
