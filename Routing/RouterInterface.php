<?php
namespace lily\Routing;

/**
 * The main interface in which the router classes must implement
 * Interface RouterInterface
 * @package lily\Routing
 */
interface RouterInterface
{
    /**
     * Parses the url to extract controller name, action name and request parameters
     * @param $url string the requested url
     */
    public function parseRoute($url);

    /**
     * Checks if the route is valid and prepares the router for
     * the front controller
     * @return bool
     */
    public function route();

}