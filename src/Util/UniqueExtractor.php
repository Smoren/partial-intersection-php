<?php

declare(strict_types=1);

namespace Smoren\PartialIntersection\Util;

use Closure;
use Generator;

/**
 * Tool for extracting unique IDs and hashes of any PHP variables and data structures.
 *
 * Based on PHP Type Tool's UniqueExtractor.
 * @see https://github.com/Smoren/type-tools-php
 * @see https://github.com/Smoren/type-tools-php/blob/master/src/UniqueExtractor.php
 */
class UniqueExtractor
{
    /**
     * Returns unique ID string of given variable by its value and type.
     *
     * If $strict is true:
     *  - scalars: result is unique strictly by type;
     *  - objects: result is unique by instance;
     *  - arrays: result is unique by serialized value;
     *  - resources: result is unique by instance.
     *
     * If $strict is false:
     *  - scalars: result is unique by value;
     *  - objects: result is unique by serialized value;
     *  - arrays: result is unique by serialized value.
     *  - resources: result is unique by instance.
     *
     * @param mixed $var
     * @param bool $strict
     *
     * @return string
     */
    public static function getString($var, bool $strict): string
    {
        switch (true) {
            case is_array($var):
                return 'array_'.serialize($var);
            case is_resource($var):
                preg_match('/#([0-9]+)$/', (string)$var, $matches);
                return 'resource_'.$matches[1];
            case $var instanceof Generator:
                return 'generator_'.spl_object_id($var);
            case $var instanceof Closure:
                return 'closure_'.spl_object_id($var);
            case is_object($var):
                return 'object_'.($strict ? spl_object_id($var) : serialize($var));
            case gettype($var) === 'boolean':
                return 'boolean_'.(int)$var;
            case $strict:
                return gettype($var).'_'.$var;
            case !$var:
                return 'boolean_0';
            case strval($var) === '1':
                return 'boolean_1';
            case is_numeric($var):
                return 'numeric_'.(float)$var;
            default:
                return 'scalar_'.$var;
        }
    }
}
