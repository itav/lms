<?php

use Optomedia\Customer\Controller\CustomerOriginController;
use Optomedia\Tools\DataControl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteDispatcher
{
    static public function dispatch(Request $request)
    {
        $route = $request->get('o');
        if($route){
            $function = DataControl::camelize($route). 'Reaction';
            if(method_exists(self::class, $function)){
                return self::$function($request);
            }
            $parts = explode('_', $route);
            if(count($parts) != 3 ){
               return self::notFoundReaction(); 
            }
            $controllerStr = 'Optomedia\\' . ucfirst($parts[0]) . '\\Controller\\' . ucfirst($parts[0]) . ucfirst($parts[1]) . 'Controller';
            if(!class_exists($controllerStr)){
                return self::notFoundReaction();
            }
            $controller = new $controllerStr();
            $methodStr = $parts[2] . 'Action';
            if(!method_exists($controller, $methodStr)){
                return self::notFoundReaction();
            }
            ViewData::setData($controller->$methodStr($request));
            return ViewData::getViewData();
            
        }else{
            return self::notFoundReaction();
        }
    }
    
    static public function notFoundReaction()
    {
        ViewData::setCode(Response::HTTP_NOT_FOUND);
        ViewData::setTempl('404.tpl');
        return ViewData::getViewData();
    }
    
    static public function customerOriginDelReaction(Request $request)
    {
        $id = $request->get('id');
        if($id){
            $controller = new CustomerOriginController();
            $controller->delAction($id);
        }
        header('Location: ?m=optomedia&o=customer_origin_list');
        die();
    } 
}

class ViewData
{
    static private $data = '';
    static private $templ = 'app.tpl';
    static private $code = Response::HTTP_OK;
    
    public static function setData($data) {
        self::$data = $data;
    }

    public static function setTempl($templ) {
        self::$templ = $templ;
    }

    public static function setCode($code) {
        self::$code = $code;
    }

    public static function getViewData()
    {
        return [
            'data' => self::$data,
            'templ' => self::$templ, 
            'code' => self::$code,
        ]; 
    }    
}

class View
{
    public static function renderView(&$SMARTY)
    {
        $request = Request::createFromGlobals();
        $response = new Response();
        $response->prepare($request);
        $viewData = RouteDispatcher::dispatch($request);
        $content = $viewData['data'];
        $templ = $viewData['templ'];
        $code = $viewData['code'];
        //die(print_r($content, true));
        
        $SMARTY->assign('content', $content);
        $html = $SMARTY->fetch($templ);
        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'text/html');
        $response->setContent($html);
        $response->send();        
    }
}

View::renderView($SMARTY);