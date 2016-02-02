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
            $data = $controller->editAction();
            $templ = 'customer/view/originEdit.tpl';
            break;
        case 'customer_origin_del': 
            $data = $controller->delAction();
            header('Location: http://www.onet.pl');
            break;
        default:
            $templ = '404.tpl';
            break;
    }
    $SMARTY->assign($data);
}
$SMARTY->display($templ);