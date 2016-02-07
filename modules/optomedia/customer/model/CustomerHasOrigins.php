<?php

namespace Optomedia\Customer\Model;

use Optomedia\Tools\ListCollection;
use Optomedia\Customer\Model\CustomerHasOrigin;

class CustomerHasOrigins extends ListCollection
{
    public function rpush($obj)
    {
        if($obj instanceof CustomerHasOrigin ){
            return parent::rpush($obj);
        }
        throw new \Exception("Wrong type ");
    }
    public function lpush($obj)
    {
        if($obj instanceof CustomerHasOrigin ){
            return parent::lpush($obj);
        }
        throw new \Exception("Wrong type ");
    }
    public function append( $obj)
    {
        if($obj instanceof CustomerHasOrigin ){
            return parent::append($obj);
        }
        throw new \Exception("Wrong type ");
    }
    /**
     * @param mixed $index
     * @param CustomerHasOrigin $val
     * @return void
     * @throws \Exception
     */
    public function offsetSet($index, $val)
    {
        if($val instanceof CustomerHasOrigin ){
            return parent::offsetSet($index, $val);
        }
        throw new \Exception("Wrong type ");
    }
    /**
     * @return CustomerHasOrigin
     */
    public function rpop()
    {
        return parent::rpop();
    }
    /**
     * @return CustomerHasOrigin
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
     * @return CustomerHasOrigin
     */
    public function current()
    {
        return parent::current();
    }
    /**
     * @param int $index
     * @return CustomerHasOrigin
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}