<?php

namespace Optomedia\Customer\Controller;

use Optomedia\Customer\Model\Repository\OriginRepository;
use Optomedia\Tools\HtmlTable;
use Symfony\Component\Form\Extension\Core\Type;
use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\Repository\CustomerHasOriginRepository;
use Optomedia\Tools\AbstractController;

class CustomerOriginController extends AbstractController
{

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

        $return = [
            'title' => 'Lista źródeł pochodzenia klientów',
            'table' => $tbl->render(),
        ];
        return $this->get('twig')->render('customer/view/origin/list.html.twig', $return);
    }

    public function addAction() {
        
    }

    public function editAction($request) {
        $formFactory = $this->get('form_factory');
        $form = $formFactory->createBuilder()
                ->add('task', Type\CheckboxType::class)
                ->add('dueDate', Type\DateType::class)
                ->getForm();


        $form->handleRequest($request);
        if ($form->isValid()) {
            return '<h3>Valid!</h3>';
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

    public function prepareForm($id) {
        if ($id) {
            $repo = new OriginRepository();
            $origin = $repo->find($id);
        } else {
            $origin = new Origin();
        }
        $form = new Form("form-elements");
        $form->configure(array(
            "prevent" => array("bootstrap"),
            "action" => basename($_SERVER["SCRIPT_NAME"]) . '?m=optomedia&o=customer_origin_edit&id=' . $id,
        ));
        $form->addElement(new Element\Textbox("Nazwa:", "name", [

            "validation" => new Validation\RegExp("/pfbc/", "Error: The %element% field must contain following keyword - \"pfbc\"."),
            "longDesc" => "The RegExp validation class provides the means to apply custom validation to an element.  Its constructor 
            includes two parameters: the regular expression pattern to test and the error message to display if the pattern is not matched."
        ]));
        $form->addElement(new Element\Textarea("Opis:", "description", [
        ]));
        $form->addElement(new Element\Button("Zapisz"));
        $form->addElement(new Element\Button("Anuluj", "button", array(
            "onclick" => 'location.href = "?m=optomedia&o=customer_origin_list"',
        )));
        return $form->render(true);
    }

    public function prepareOriginSelect() {

    }
}
