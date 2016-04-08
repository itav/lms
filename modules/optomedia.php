<?php

use Optomedia\Customer\Controller\CustomerOriginController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();
$response->prepare($request);

if (null === $request->get('o')) {
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $templ = '404.tpl';
} else {
    $templ = 'app.tpl';
    $controller = new CustomerOriginController();
    switch ($request->get('o')) {
        case 'customer_origin_list': 
            $content = $controller->listAction($request);
            break;
        case 'customer_origin_info': 
            $content = $controller->infoAction($request);
            break;
        case 'customer_origin_add': 
            $content = $controller->addAction($request);         
            break;
        case 'customer_origin_edit':
            $content = $controller->editAction($request);           
            
            break;
        case 'customer_origin_del':
            if(isset($_GET['id']) && $id = (int)$_GET['id']){
                $content = $controller->delAction($id);
            }
            header('Location: ?m=optomedia&o=customer_origin_list');
            die();
            break;
        default:
            $content = 'module not found';
            $templ = '404.tpl';
            break;
    }
    $SMARTY->assign('content', $content);
}

$html = $SMARTY->fetch($templ);
$response->headers->set('Content-Type', 'text/html');
$response->setContent($html);
$response->send();

