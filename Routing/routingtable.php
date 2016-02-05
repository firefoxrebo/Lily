<?php

namespace Lily\Routing;

class RoutingTable
{
    /**
     * @var array
     */
    private $_routingTable = array();

    /**
     * @param $routeID
     * @param array $routeDefinition
     */
    public function add($routeID, array $routeDefinition)
    {
        $this->_routingTable[$routeID] = array();
        $this->_routingTable[$routeID]['_controller_'] = $routeDefinition['_controller_path_'];
        $this->_routingTable[$routeID]['_action_'] = $routeDefinition['_action_'];

        $controllerName = explode('\\', $routeDefinition['_controller_path_']);
        $controllerName = strtolower($controllerName[count($controllerName) - 1]);
        $url = preg_replace(
            '/({controller})/i',
            $controllerName,
            $routeDefinition['_url_']
        );

        $url = preg_replace(
            '/({action})/i',
            $routeDefinition['_action_'],
            $url
        );

        if (array_key_exists('_roles_', $routeDefinition)) {
            $roles = $routeDefinition['_roles_'];
            foreach ($roles as $role => $pattern) {
                $url = preg_replace(
                    '/({' . $role . '})/i',
                    $pattern,
                    $url
                );
            }
            $this->_routingTable[$routeID]['_params_'] = array_keys($routeDefinition['_roles_']);
        }

        $this->_routingTable[$routeID]['_url_'] = $url;
        $this->_routingTable[$routeID]['_method_'] = explode(',', $routeDefinition['_method_']);
    }

    /**
     * Check wither the routing table has a specific route
     * @param Router $router
     * @return bool
     */
    public function has(Router $router)
    {
        $found = false;
        foreach ($this->_routingTable as $routeID => $routeDetails) {
            if (preg_match("/^" . str_replace('/', '\/', $routeDetails['_url_']) . "$/i", $router->getFinalRequestedId()) &&
                in_array($router->getRequest()->getMethod(), $this->_routingTable[$routeID]['_method_'])) {
                $found = true;
                break;
            }
        }
        $router->setController($this->_routingTable[$routeID]['_controller_']);
        $router->setAction($this->_routingTable[$routeID]['_action_']);
        if(!empty($router->getParams())) {
            $index = 0;
            $parameters = array();
            $routerFetchedParameters = $router->getParams();
            foreach ($this->_routingTable[$routeID]['_params_'] as $parameter) {
                $parameters[$parameter] = $routerFetchedParameters[$index++];
            }
            $router->setParams($parameters);
        }
        return $found;
    }
}