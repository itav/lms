<?php
/**
 * Created by PhpStorm.
 * User: sylwester
 * Date: 07.01.16
 * Time: 09:31
 */

namespace Optomedia\Tools;

use ArrayAccess;
use Countable;
use Iterator;
use IteratorAggregate;
use Traversable;
/**
 * Class Collection
 * Object containing array of objects and can be iterating by foreach
 * !! Object iterator do not clone collection. Don't remove object during iterating
 * !! Only read and update collection allowed
 * !! Do not unset in foreach loop
 * @package Ipresso\Tools
 */
class Collection implements IteratorAggregate, ArrayAccess, Countable
{
    protected $collection = [];
    public function __construct($obj = null)
    {
        if (is_array($obj)) {
            $this->collection = $obj;
        } elseif ($obj) {
            $this->collection[] = $obj;
        }
    }
    public function append($obj)
    {
        $this->collection[] = $obj;
        return $this;
    }
    public function shift()
    {
        return array_shift($this->collection);
    }
    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return \current($this->collection);
    }
    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        \next($this->collection);
    }
    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return \key($this->collection);
    }
    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        array_key_exists($this->key(), $this->collection);
    }
    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->collection);
    }
    public function keys()
    {
        return array_keys($this->collection);
    }
    /**
     * @param int $index
     * @return bool
     */
    public function offsetExists($index)
    {
        return array_key_exists($index, $this->collection);
    }
    /**
     * @param mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {
        return $this->collection[$index];
    }
    /**
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        unset($this->collection[$index]);
    }
    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->collection);
    }
    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new CollectionIterator($this);
    }
    public function __clone()
    {
        $this->collection = array_map(function($item){return clone $item;}, $this->collection);
    }
    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if(!$offset){
            $this->collection[] = $value;
            return;
        }
        $this->collection[$offset] = $value;
    }
}
class CollectionIterator implements Iterator
{
    private $collection;
    private $index = 0;
    private $keys;
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->keys = $this->collection->keys();
    }
    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->collection->offsetGet($this->index);
    }
    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;
    }
    /**
     * Move backward to prev element
     * @link http://php.net/manual/en/iterator.prev.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function prev()
    {
        $this->index--;
    }
    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }
    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->collection->offsetExists($this->index);
    }
    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }
}