<?php

use Optomedia\Customer\Controller\CustomerOriginController;

if (!isset($_GET['o'])) {
    $templ = '404.tpl';
} else {
    $data = [];
    $controller = new CustomerOriginController();
    switch ($_GET['o']) {
        case 'customer_origin_list': 
            $data = $controller->listAction();
            $templ = 'customer/view/originList.tpl';
            break;
        case 'customer_origin_add': 
            $data = $controller->addAction();
            $templ = 'customer/view/originAdd.tpl';
            break;
        case 'customer_origin_edit':
            if(isset($_GET['id']) && $id = (int)$_GET['id']){
                $data = $controller->editAction($id);
            }            
            $templ = 'customer/view/originEdit.tpl';
            break;
        case 'customer_origin_del':
            if(isset($_GET['id']) && $id = (int)$_GET['id']){
                $data = $controller->delAction($id);
            }
            header('Location: ?m=optomedia&o=customer_origin_list');
            die();
            break;
        default:
            $templ = '404.tpl';
            break;
    }
    $SMARTY->assign($data);
}
$SMARTY->display($templ);