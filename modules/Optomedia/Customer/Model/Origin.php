<?php

namespace Optomedia\Customer\Model;

class Origin
{
    const STATUS_NEW = 1;
    const STATUS_DELETE = 2;
    
    /**
     *
     * @var int
     */
    private $id;
    /**
     *
     * @var string
     */
    private $name;
    /**
     *
     * @var string
     */    
    private $description;
    /**
     *
     * @var int
     */    
    private $idStatus = 1;    
    
    /**
     * @return int 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * 
     * @param int $id
     * @return Origin 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * 
     * @param string $name
     * @return Origin 
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * 
     * @param string $description
     * @return Origin 
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * @return int 
     */
    public function getIdStatus()
    {
        return $this->idStatus;
    }
    /**
     * 
     * @param int $idStatus
     * @return Origin 
     */
    public function setIdStatus($idStatus)
    {
        $this->idStatus = $idStatus;
        return $this;
    }    
}
