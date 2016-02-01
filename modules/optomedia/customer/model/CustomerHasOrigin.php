<?php

namespace Optomedia\Customer\Model;

class CustomerHasOrigin
{
    /**
     *
     * @var int
     */
    private $idCustomer;
    /**
     *
     * @var int
     */
    private $idOrigin;    
    /**
     *
     * @var string
     */  
    private $description;
    /**
     *
     * @var int
     */
    private $idConnection;
    /**
     *
     * @var int
     */
    private $idStatus;    
    
    /**
     * @return int
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }
    /**
     * 
     * @param int $idCustomer
     * @return CustomerHasOrigin 
     */
    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;
        return $this;
    }
    /**
     * @return int
     */
    public function getIdOrigin()
    {
        return $this->idOrigin;
    }
    /**
     * 
     * @param int $idOrigin
     * @return CustomerHasOrigin 
     */
    public function setIdOrigin($idOrigin)
    {
        $this->idOrigin = $idOrigin;
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
    public function getIdConnection()
    {
        return $this->idConnection;
    }
    /**
     * 
     * @param int $idConnection
     * @return CustomerHasOrigin 
     */
    public function setIdconnection($idConnection)
    {
        $this->idConnection = $idConnection;
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
     * @param int $status
     * @return CustomerHasOrigin 
     */
    public function setIdStatus($status)
    {
        $this->idStatus = $status;
        return $this;
    }    
}



