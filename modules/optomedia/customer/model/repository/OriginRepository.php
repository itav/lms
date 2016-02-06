<?php

namespace Optomedia\Customer\Model\Repository;
use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\Origins;

class OriginRepository
{
    private $db;
    
    public function __construct() {
        $this->db = \LMSDB::getInstance();
    }
    
    /**
     * 
     * @param int $id
     * @return Origin
     */
    public function find($id)
    {
        $origin = new Origin();
        return $origin;
    }
    
    /**
     * 
     * @return Origins
     */
    public function findAll()
    {
        $origins = new Origins();
        $sql = "SELECT * FRIM origin where id_status != ? ";
        $this->db->GetAll($sql, [Origin::STATUS_DELETE]);
        
        return $origins;
    }
    
    /**
     * @param Origin $origin
     * @return bool
     */
    public function update(Origin $origin)
    {
        
    }    
    
    /**
     * @param Origin $origin
     * @return int
     */
    public function insert(Origin $origin)
    {

    }   
}
