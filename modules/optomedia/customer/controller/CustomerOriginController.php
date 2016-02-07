<?php

namespace Optomedia\Customer\Controller;

use Optomedia\Customer\Model\Repository\OriginRepository;
use Optomedia\Tools\HtmlTable;
use Optomedia\Tools\HtmlForm;
use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\CustomerHasOrigin;
use Optomedia\Customer\Model\Repository\CustomerHasOriginRepository;

class CustomerOriginController {

    public function listAction() {

        $repo = new OriginRepository();
        $origins = $repo->findAll();
        $tbl = new HtmlTable('', 'lmsbox');
        $tbl->addRow();
        $tbl->addCell('id', '', 'header');
        $tbl->addCell('nazwa', '', 'header');
        $tbl->addCell('opis', '', 'header');
        $tbl->addCell('operacje', '', 'header');

        foreach ($origins as $origin) {
            $tbl->addRow();
            $tbl->addCell($id = $origin->getId(), 'num');
            $tbl->addCell($origin->getName());
            $tbl->addCell($origin->getDescription());
            $tbl->addCell(
                    "<a href='?m=optomedia&o=customer_origin_edit&id=$id'><img src='img/edit.gif'></a>"
                    . "<a href='?m=optomedia&o=customer_origin_del&id=$id'><img src='img/delete.gif'></a>"
            );
        }

        $tbl->addRow();
        $tbl->addCell('Razem:' . $origins->count(), 'foot', 'data', array('colspan' => 4));

        return [
            'title' => 'Lista źródeł pochodzenia klientów',
            'table' => $tbl->render(),
        ];
    }

    public function addAction() {
        
    }

    public function editAction($id) {


        return [
            'form' => $frmStr,
        ];
    }

    public function delAction($id) {

        $relationRepo = new CustomerHasOriginRepository();
        if (0 === $relationRepo->countByOrigin($id)) {

            $origin = new Origin();
            $origin
                    ->setId($id)
                    ->setIdStatus(Origin::STATUS_DELETE);
            $originRepo = new OriginRepository();
            $originRepo->update($origin);
        }
    }

    public function addCustomerRelationAction($idOrigin, $idCustomer, $descr = '', $idExternal = null) {
        
    }

    public function delCustomerRelationAction($idOrigin = null, $idCustomer = null) {
        
    }

}
