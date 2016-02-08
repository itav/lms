<?php

namespace Optomedia\Customer\Model\Repository;

use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\Origins;
use Optomedia\Tools\DataTools;

class OriginRepository {

    private $db;

    public function __construct() {
        $this->db = \LMSDB::getInstance();
    }

    /**
     * 
     * @param int $id
     * @return Origin
     */
    public function find($id) {

        $sql = "SELECT * FROM origin where id = ? AND id_status != ? ";
        $row = $this->db->GetRow($sql, [$id, Origin::STATUS_DELETE]);
        return $this->hydrateOrigin($row);
    }

    /**
     * 
     * @return Origins
     */
    public function findAll() {
        $origins = new Origins();
        $sql = "SELECT * FROM origin where id_status != ? ";
        $rows = $this->db->GetAll($sql, [Origin::STATUS_DELETE]);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $origins->rpush($this->hydrateOrigin($row));
            }
        }

        return $origins;
    }

    /**
     * @param Origin $origin
     * @return bool
     */
    public function update(Origin $origin) {
        $sub = $this->prepareUpdateSubQuery($origin);
        $sql = "UPDATE origin SET $sub WHERE id = ? ";
        return $this->db->Execute($sql, [$origin->getId()]);
    }

    /**
     * @param Origin $origin
     * @return int
     */
    public function insert(Origin $origin) {
        
    }

    /**
     * @param array $row
     * @return Origin
     */
    private function hydrateOrigin($row) {
        $origin = new Origin();
        if ($row) {
            $origin->setId((int)$row['id']);
            $origin->setName($row['name']);
            $origin->setDescription($row['description']);
            $origin->setIdStatus((int)$row['id_status']);
        }
        return $origin;
    }
    
    /**
     * @param Origin $entity
     * @return string
     */
    private function prepareUpdateSubQuery($entity) {
        $values = DataTools::unbindOrm($entity);
        if(isset($values['id'])){
            unset($values['id']);
        }
        $str = '';
        $i = 0;
        foreach($values as $k => $v ){
            $str .= (!$i++) ? " $k = $v " : " , $k = $v ";
        }
        return $str;
    }    

}
