<?php
/**
 * Created by PhpStorm.
 * User: sylwester
 * Date: 07.01.16
 * Time: 11:25
 */

namespace Optomedia\Tools;

class ListCollection extends Collection
{
    const IT_KEEP = 0;
    const IT_DELETE = 1;
    private $iteratorMode = self::IT_KEEP;
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
        return \array_pop($this->collection);
    }
    /**
     * @return mixed
     */
    public function lpop()
    {
        return \array_shift($this->collection);
    }
    /**
     * @return SmsContent
     */
    public function fetch()
    {
        $item = $this->current();
        $this->next();
        return $item;
    }
    /**
     * @return int
     */
    public function getIteratorMode()
    {
        return $this->iteratorMode;
    }
    /**
     * @param int $iteratorMode
     * @return ListCollection
     */
    public function setIteratorMode($iteratorMode)
    {
        $this->iteratorMode = $iteratorMode;
        return $this;
    }
    public function next(){
        parent::next();
        if($this->iteratorMode === self::IT_DELETE){
            $this->shift();
        }
    }
}