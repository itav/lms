<?php

namespace Optomedia\Customer\Model\Repository;

use Optomedia\Customer\Model\CustomerHasOrigin;
use Optomedia\Customer\Model\CustomerHasOrigins;

class CustomerHasOriginRepository {

    private $db;

    public function __construct() {
        $this->db = \LMSDB::getInstance();
    }

    /**
     * 
     * @param int $id
     * @return CustomerHasOrigin
     */
    public function find($id) {

        $sql = "SELECT * FROM origin where id = ?";
        $row = $this->db->GetOne($sql, [$id]);
        return $this->hydrateCustomerHasOrigin($row);
    }

    /**
     * 
     * @return CustomerHasOrigins
     */
    public function findAll() {
        $connections = new CustomerHasOrigin();
        $sql = "SELECT * FROM customer_has_origin ";
        $rows = $this->db->GetAll($sql);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $connections->rpush($this->hydrateCustomerHasOrigin($row));
            }
        }
        return $connections;
    }
    /**
     * @param int $idOrigin
     * @return CustomerHasOrigins
     */
    public function findAllByOrigin($idOrigin) {
        $connections = new CustomerHasOrigins();
        $sql = "SELECT * FROM customer_has_origin where id_origin = ?";
        $rows = $this->db->GetAll($sql, [$idOrigin]);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $connections->rpush($this->hydrateCustomerHasOrigin($row));
            }
        }
        return $connections;
    }
    
    /**
     * @param int $idOrigin
     * @return int
     */
    public function countByOrigin($idOrigin) {
        $sql = "SELECT count(id) FROM customer_has_origin where id_origin = ?";
        return (int)$this->db->GetOne($sql, [$idOrigin]);
    }
    
    /**
     * @param int $idCustomer
     * @return CustomerHasOrigins
     */
    public function findAllByCustomer($idCustomer) {
        $connections = new CustomerHasOrigins();
        $sql = "SELECT * FROM customer_has_origin where id_customer = ?";
        $rows = $this->db->GetAll($sql, [$idCustomer]);
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $connections->rpush($this->hydrateCustomerHasOrigin($row));
            }
        }
        return $connections;
    }
    
    /**
     * @param CustomerHasOrigin $entity
     * @return bool
     */
    public function update(CustomerHasOrigin $entity) {
        
    }

    /**
     * @param CustomerHasOrigin $entity
     * @return int
     */
    public function insert(CustomerHasOrigin $entity) {
        
    }

    /**
     * @param CustomerHasOrigin $entity
     * @return int
     */
    public function remove(CustomerHasOrigin $entity) {
        
    }
    
    
    
    /**
     * @param array $row
     * @return CustomerHasOrigin
     */
    public function hydrateCustomerHasOrigin($row) {
        $entity = new CustomerHasOrigin();
        if ($row) {
            $entity->setId((int) $row['id']);
            $entity->setIdCustomer((int)$row['id_customer']);
            $entity->setIdOrigin((int)$row['id_origin']);
            $entity->setDescription($row['description']);
            $entity->setIdconnection($row['id_connection'] ? (int) $row['id_connection'] : null);
        }
        return $entity;
    }

}
