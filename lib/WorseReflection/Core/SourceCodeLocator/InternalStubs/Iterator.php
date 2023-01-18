<?php

namespace Phpactor202301;

/**
 * @link https://wiki.php.net/rfc/iterable
 */
interface iterable
{
}
/**
 * @link https://wiki.php.net/rfc/iterable
 */
\class_alias('Phpactor202301\\iterable', 'iterable', \false);
/**
 * Interface to detect if a class is traversable using foreach.
 * Abstract base interface that cannot be implemented alone.
 * Instead it must be implemented by either {@see IteratorAggregate} or {@see Iterator}.
 *
 * @link https://php.net/manual/en/class.traversable.php
 * @template TKey
 * @template TValue
 *
 * @template-implements iterable<TKey, TValue>
 */
interface Traversable extends \iterable
{
}
/**
 * Interface to detect if a class is traversable using foreach.
 * Abstract base interface that cannot be implemented alone.
 * Instead it must be implemented by either {@see IteratorAggregate} or {@see Iterator}.
 *
 * @link https://php.net/manual/en/class.traversable.php
 * @template TKey
 * @template TValue
 *
 * @template-implements iterable<TKey, TValue>
 */
\class_alias('Phpactor202301\\Traversable', 'Traversable', \false);
/**
 * Interface to create an external Iterator.
 * @link https://php.net/manual/en/class.iteratoraggregate.php
 * @template TKey
 * @template TValue
 * @template-implements Traversable<TKey, TValue>
 */
interface IteratorAggregate extends \Traversable
{
    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable<TKey, TValue>|TValue[] An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @throws Exception on failure.
     */
    public function getIterator() : \Traversable;
}
/**
 * Interface to create an external Iterator.
 * @link https://php.net/manual/en/class.iteratoraggregate.php
 * @template TKey
 * @template TValue
 * @template-implements Traversable<TKey, TValue>
 */
\class_alias('Phpactor202301\\IteratorAggregate', 'IteratorAggregate', \false);
/**
 * Interface for external iterators or objects that can be iterated
 * themselves internally.
 * @link https://php.net/manual/en/class.iterator.php
 * @template TKey
 * @template TValue
 * @template-implements Traversable<TKey, TValue>
 */
interface Iterator extends \Traversable
{
    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return TValue Can return any type.
     */
    public function current();
    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() : void;
    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return TKey|null TKey on success, or null on failure.
     */
    public function key();
    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() : bool;
    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() : void;
}
/**
 * Interface for external iterators or objects that can be iterated
 * themselves internally.
 * @link https://php.net/manual/en/class.iterator.php
 * @template TKey
 * @template TValue
 * @template-implements Traversable<TKey, TValue>
 */
\class_alias('Phpactor202301\\Iterator', 'Iterator', \false);
