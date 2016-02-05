<?php
namespace Lily\FrontController;

use Lily\HTTP\Request;
use Lily\HTTP\Response;
use Lily\Routing;
use Lily\Template;
use Lily\Registry;


class FrontController 
{

    private $_controller;
    private $_action;
    private $_params = array();
    private $_registry;
    private $_template;
    private $_request;
    private $_response;
    
    public function __construct(Routing\Router $router, Registry\Registry $registry, Template\Template $template, Request $request, Response $response)
    {
        $this->_controller = $router->getController();
        $this->_action = $router->getAction();
        $this->_params = $router->getParams();
        $this->_request = $request;
        $this->_response = $response;
        $this->_registry = $registry;
        $this->_template = $template;
    }

    public function dispatch()
    {
        $className = $this->_controller . 'controller';
        $controller = new $className ();
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setRegistry($this->_registry);
        $controller->setParams($this->_params);
        $controller->setTemplate($this->_template);
        $method = strtolower($this->_action) . 'Action';
        if(method_exists($controller, $method)) {
            $controller->$method();
        }
    }
}