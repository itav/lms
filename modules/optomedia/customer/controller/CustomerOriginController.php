<?php

namespace Optomedia\Customer\Controller;

use Optomedia\Customer\Model\Repository\OriginRepository;
use Optomedia\Tools\HtmlTable;
use Optomedia\Tools\HtmlForm;
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;
use Optomedia\Customer\Model\Origin;
use Optomedia\Customer\Model\CustomerHasOrigin;
use Optomedia\Customer\Model\Repository\CustomerHasOriginRepository;

class CustomerOriginController
{

    public function listAction()
    {

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

    public function addAction()
    {
        
    }

    public function editAction($id)
    {
        $form = $this->prepareForm($id);
        if(Form::isValid("form-elements", false)) {
                /*The form\'s submitted data has been validated.  Your script can now proceed with any 
                further processing required.*/
            echo("form is valid");
        }
        
        return [
            'form' => $form,
        ];
        
        
    }

    public function delAction($id)
    {

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

    public function addCustomerRelationAction($idOrigin, $idCustomer, $descr = '', $idExternal = null)
    {
        
    }

    public function delCustomerRelationAction($idOrigin = null, $idCustomer = null)
    {
        
    }

    public function prepareForm($id)
    {
        if($id){
            $repo = new OriginRepository();
            $origin = $repo->find($id);
        }else{
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
        $form->addElement(new Element\Textarea("Opis:", "description",[

        ]));
        $form->addElement(new Element\Button("Zapisz"));
        $form->addElement(new Element\Button("Anuluj", "button", array(
            "onclick" => 'location.href = "?m=optomedia&o=customer_origin_list"',
        )));
        return $form->render(true);
    }

    public function prepareOriginSelect()
    {

        $repo = new OriginRepository();
        $origins = $repo->findAll();
        $options = [];
        $options['null'] = 'Wybierz';
        foreach ($origins as $origin) {
            $options[$origin->getId()] = $origin->getName();
        }
        $select = new Element\Select("Select:", "Select", $options);
        ob_start();
        $select->render();
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function prepareFormExample($id)
    {
        $options = array("Option #1", "Option #2", "Option #3");
        $form = new Form("form-elements");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => basename($_SERVER["SCRIPT_NAME"]) . '?m=optomedia&o=customer_origin_edit&id=' . $id,
        ));
        $form->addElement(new Element\Hidden("form", "form-elements"));
        $form->addElement(new Element\HTML('<legend>Standard</legend>'));
        $form->addElement(new Element\Textbox("Textbox:", "Textbox"));
        $form->addElement(new Element\Password("Password:", "Password"));
        $form->addElement(new Element\File("File:", "File"));
        $form->addElement(new Element\Textarea("Textarea:", "Textarea"));
        $form->addElement(new Element\Select("Select:", "Select", $options));
        $form->addElement(new Element\Radio("Radio Buttons:", "RadioButtons", $options));
        $form->addElement(new Element\Checkbox("Checkboxes:", "Checkboxes", $options));
        $form->addElement(new Element\HTML('<legend>HTML5</legend>'));
        $form->addElement(new Element\Phone("Phone:", "Phone"));
        $form->addElement(new Element\Search("Search:", "Search"));
        $form->addElement(new Element\Url("Url:", "Url"));
        $form->addElement(new Element\Email("Email:", "Email"));
        $form->addElement(new Element\Date("Date:", "Date"));
        $form->addElement(new Element\DateTime("DateTime:", "DateTime"));
        $form->addElement(new Element\DateTimeLocal("DateTime-Local:", "DateTimeLocal"));
        $form->addElement(new Element\Month("Month:", "Month"));
        $form->addElement(new Element\Week("Week:", "Week"));
        $form->addElement(new Element\Time("Time:", "Time"));
        $form->addElement(new Element\Number("Number:", "Number"));
        $form->addElement(new Element\Range("Range:", "Range"));
        $form->addElement(new Element\Color("Color:", "Color"));
        $form->addElement(new Element\HTML('<legend>jQuery UI</legend>'));
        $form->addElement(new Element\jQueryUIDate("Date:", "jQueryUIDate"));
        $form->addElement(new Element\Checksort("Checksort:", "Checksort", $options));
        $form->addElement(new Element\Sort("Sort:", "Sort", $options));
        $form->addElement(new Element\HTML('<legend>WYSIWYG Editor</legend>'));
        $form->addElement(new Element\TinyMCE("TinyMCE:", "TinyMCE"));
        $form->addElement(new Element\CKEditor("CKEditor:", "CKEditor"));
        $form->addElement(new Element\HTML('<legend>Custom/Other</legend>'));
        $form->addElement(new Element\State("State:", "State"));
        $form->addElement(new Element\Country("Country:", "Country"));
        $form->addElement(new Element\YesNo("Yes/No:", "YesNo"));
        $form->addElement(new Element\Captcha("Captcha:"));
        $form->addElement(new Element\Button);
        $form->addElement(new Element\Button("Cancel", "button", array(
            "onclick" => "history.go(-1);"
        )));
        return $form->render(true);
    }

}
