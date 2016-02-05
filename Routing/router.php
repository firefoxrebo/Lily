<?php

namespace Lily\Routing;
use Lily\HTTP\Request;
use Lily\HTTP\Response;

class Router
{
    /**
     * Default Controller Name if none is specified in the URI
     */
    const DEFAULT_CONTROLLER = 'index';

    /**
     * Default Action to call if none is specified in the URI
     */
    const DEFAULT_ACTION = 'default';

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Response
     */
    private $_response;

    /**
     * @var string Controller Name
     */
    private $_controller;

    /**
     * @var string Action to call
     */
    private $_action;

    /**
     * @var array request parameters
     */
    private $_params = array();

    /**
     * @var RoutingTable
     */
    private $_routeCollection;

    /**
     * @var the final requested URI;
     */
    public $_finalRequestedURI;

    /**
     * Sets the Request Object
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Sets the Response Object
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Sets the controller name
     * @param $controller the controller fully qualified name
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /**
     * Returns the controller fully qualified name
     * @return string The controller
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Sets the action name
     * @param $action the action name
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * Returns the action to load
     * @return string The action
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Sets the request parameters array
     * @param array $params the request parameters array
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
    }

    /**
     * Returns the request parameters array
     * @return array the request parameters
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Returns the final request URI
     * @return string the final requested url
     */
    public function getFinalRequestedId()
    {
        return $this->_finalRequestedURI;
    }

    /**
     * @param RoutingTable $routeCollection
     * @return $this
     */
    public function addRoutingTable(RoutingTable $routeCollection)
    {
        $this->_routeCollection = $routeCollection;
        return $this;
    }

    /**
     * Parses the url to extract controller name, action name and request parameters
     * @param $url The requested url
     */
    private function parseRoute($url)
    {
        // Check if the project is on the domain root or a sub folder
        if(APP_READS_FROM === 'subfolder') {
            $url = explode(APP_SUB_FOLDER, $url)[1];
            $url = ltrim($url, '/');
        }

        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        @list($controller, $action, $params) = explode('/', $url, 3);

        if(isset($controller) && !empty($controller)) {
            $this->_controller = strtolower($controller);
        } else {
            $this->_controller = self::DEFAULT_CONTROLLER;
        }

        if(isset($action) && !empty($action)) {
            $this->_action = strtolower($action);
        } else {
            $this->_action = self::DEFAULT_ACTION;
        }

        if(isset($params) && !empty($params)) {
            $this->_params = explode('/', $params);
        } else {
            $this->_params = array();
        }

        $this->_finalRequestedURI  = '/' . $this->_controller;;
        $this->_finalRequestedURI .= '/' . $this->_action;
        $this->_finalRequestedURI .= !empty($this->_params) ? '/' . implode('/', $this->_params) : '';
    }

    /**
     * Checks if the route is valid and prepares the router for
     * the front controller
     * @return bool
     */
    public function route()
    {
        $this->parseRoute($this->_request->getPath());
        if(true !== $this->_routeCollection->has($this))
        {
            $this->_response->setStatusCode(404);
            $this->_response->sendNotFoundHeader();
        }
    }
}