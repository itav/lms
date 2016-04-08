<?php

namespace Optomedia\Customer\Controller;

use Optomedia\Customer\Model\Repository\OriginRepository;
use Optomedia\Tools\HtmlTable;
use Symfony\Component\Form\Extension\Core\Type;
use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\Repository\CustomerHasOriginRepository;
use Optomedia\Tools\AbstractController;
use Optomedia\Customer\Form\OriginType;

class CustomerOriginController extends AbstractController
{

    public function listAction($request) {

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

        $return = [
            'title' => 'Lista źródeł pochodzenia klientów',
            'table' => $tbl->render(),
        ];
        return $this->get('twig')->render('customer/view/origin/list.html.twig', $return);
    }

    public function infoAction($request) {
        $id = $request->get('id');
        $repo = new OriginRepository();
        $origin = $repo->find($request->get('id'));
        $formFactory = $this->get('form_factory');
        $form = $formFactory->createBuilder(OriginType::class, $origin)
                ->add('editButton', Type\ButtonType::class)
                ->add('deleteButton', Type\ButtonType::class)
                ->add('cancelButton', Type\ButtonType::class)
                ->getForm();
        return $this->get('twig')->render(
                'customer/view/origin/info.html.twig', 
                array(
                    'form' => $form->createView(),
                    'link_edit' => "<a href='?m=optomedia&o=customer_origin_edit&id=$id'><img src='img/edit.gif'></a>",
                    'link_edit' => "<a href='?m=optomedia&o=customer_origin_del&id=$id'><img src='img/delete.gif'></a>",
                    'link_cancel' =>'<a href="?m=optomedia&o=customer_origin_edit"><img src="img/cancel.gif"></a>',
                    
                ));
    }    
    
    public function addAction($request) {
        $origin = new Origin();
        $formFactory = $this->get('form_factory');
        $form = $formFactory->createBuilder(OriginType::class, $origin)
                ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $repo = new OriginRepository();
            $repo->insert($origin);
            return $this->listAction($request);
        }
        return $this->get('twig')->render('customer/view/origin/add.html.twig', array('form' => $form->createView()));
    }

    public function editAction($request) {
        $repo = new OriginRepository();
        $origin = $repo->find($request->get('id'));
        $formFactory = $this->get('form_factory');
        $form = $formFactory->createBuilder(OriginType::class, $origin)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $repo->update($origin);
            return $this->listAction($request);
        }        
        return $this->get('twig')->render('customer/view/origin/edit.html.twig', array('form' => $form->createView()));
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
