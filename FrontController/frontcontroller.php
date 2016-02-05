<?php
namespace Lily\FrontController;

use Lily\HTTP\Request;
use Lily\HTTP\Response;
use Lily\Routing;
use Lily\Template;
use Lily\Registry;


class FrontController 
{

    /**
     * @var string The fully qualified controller name
     */
    private $_controller;

    /**
     * @var string The action method name to call
     */
    private $_action;

    /**
     * @var array The request parameters array
     */
    private $_params = array();

    /**
     * @var Registry\Registry The registry object
     */
    private $_registry;

    /**
     * @var Template\Template the template engine object
     */
    private $_template;

    /**
     * @var Request the http request object
     */
    private $_request;

    /**
     * @var Response the http response object
     */
    private $_response;

    /**
     * FrontController constructor.
     * @param Routing\Router $router
     * @param Registry\Registry $registry
     * @param Template\Template $template
     */
    public function __construct(Routing\Router $router, Registry\Registry $registry, Template\Template $template)
    {
        $this->_controller = $router->getController();
        $this->_action = $router->getAction();
        $this->_params = $router->getParams();
        $this->_registry = $registry;
        $this->_request = $registry->request;
        $this->_response = $registry->response;
        $this->_template = $template;
    }

    /**
     * Creating the appropriate Controller object and
     * invokes the required action method
     */
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