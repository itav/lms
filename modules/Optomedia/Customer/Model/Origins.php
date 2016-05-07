<?php

namespace Optomedia\Customer\Model;

use Optomedia\Tools\ListCollection;
use Optomedia\Customer\Model\Origin;

class Origins extends ListCollection
{
    public function rpush($obj)
    {
        if($obj instanceof Origin ){
            return parent::rpush($obj);
        }
        throw new \Exception("Wrong type ");
    }
    public function lpush($obj)
    {
        if($obj instanceof Origin ){
            return parent::lpush($obj);
        }
        throw new \Exception("Wrong type ");
    }
    public function append( $obj)
    {
        if($obj instanceof Origin ){
            return parent::append($obj);
        }
        throw new \Exception("Wrong type ");
    }
    /**
     * @param mixed $index
     * @param \Optomedia\Customer\Model\Origin $val
     * @return void
     * @throws \Exception
     */
    public function offsetSet($index, $val)
    {
        if($val instanceof Origin ){
            return parent::offsetSet($index, $val);
        }
        throw new \Exception("Wrong type ");
    }
    /**
     * @return Origin
     */
    public function rpop()
    {
        return parent::rpop();
    }
    /**
     * @return Origin
     */
    public function lpop()
    {
        return parent::lpop();
    }
    /**
     * @return Origin
     */
    public function fetch()
    {
        return parent::fetch();
    }
    /**
     * @return Origin
     */
    public function current()
    {
        return parent::current();
    }
    /**
     * @param int $index
     * @return Origin
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}