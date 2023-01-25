<?php

namespace Smoren\PartialIntersection\Util;

/**
 * @implements \Iterator<array<mixed>>
 */
class JustifyMultipleIterator implements \Iterator
{
    /**
     * @var array<\Iterator<mixed>>
     */
    protected array $iterators = [];
    /**
     * @var int
     */
    protected int $index = 0;

    /**
     * @param iterable<mixed> ...$iterables
     */
    public function __construct(iterable ...$iterables)
    {
        foreach ($iterables as $iterable) {
            $this->iterators[] = IteratorFactory::makeIterator($iterable);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @return array<mixed>
     */
    public function current(): array
    {
        return array_map(
            fn (\Iterator $iterator) => $iterator->valid() ? $iterator->current() : NoValueMonad::getInstance(),
            $this->iterators
        );
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        foreach ($this->iterators as $iterator) {
            if ($iterator->valid()) {
                $iterator->next();
            }
        }
        $this->index++;
    }

    /**
     * {@inheritDoc}
     *
     * @return int
     */
    public function key(): int
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        foreach ($this->iterators as $iterator) {
            if ($iterator->valid()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
        $this->index = 0;
    }
}
