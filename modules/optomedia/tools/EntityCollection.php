<?php
/**
 * Created by PhpStorm.
 * User: sylwester
 * Date: 07.01.16
 * Time: 11:31
 */

namespace Optomedia\Tools;

use Countable;
use Iterator;


class EntityCollection implements  Iterator, Countable
{
    /**
     * callable to fill collection (lazy instantiation)
     * @var mixed
     */
    protected $onLoad;
    protected $isLoaded = false;
    protected $collection = [];

    public function __construct($obj = null)
    {
        if(is_array($obj)){
            $this->collection = $obj;
        } elseif($obj) {
            $this->collection[] = $obj;
        }
    }

    public function setLoadCallback($fun, $obj = null)
    {
        if($obj){
            $this->onLoad = [$fun, $obj];
        }else{
            $this->onLoad = $fun;
        }
    }

    private function checkIsLoaded()
    {
        if(!$this->isLoaded && isset($this->onLoad)){
            call_user_func($this->onLoad, $this);
            $this->isLoaded = true;
        }
    }

    public function rpush($obj)
    {
        $this->collection[] = $obj;
        return $this;
    }

    public function lpush($obj)
    {
        \array_unshift($this->collection, $obj);
        return $this;
    }

    /**
     * @return mixed
     */
    public function rpop()
    {
        $this->checkIsLoaded();
        return \array_pop($this->collection);
    }

    /**
     * @return mixed
     */
    public function lpop()
    {
        $this->checkIsLoaded();
        return \array_shift($this->collection);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        $this->checkIsLoaded();
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
        $this->checkIsLoaded();
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
        $this->checkIsLoaded();
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
        $this->checkIsLoaded();
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
        $this->checkIsLoaded();
        reset($this->collection);
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
        $this->checkIsLoaded();
        return count($this->collection);
    }

}