<?php

use Lily\HTTP\Request;
use Lily\HTTP\Response;
use Lily\Routing\Router;
use Lily\Registry\Registry;
use Lily\Template\Template;
use Lily\FrontController\FrontController;
use Lily\AppConfig;
use Lily\Session\SessionManager;

/**
 * Check for the minimum requirements to run the application
 */

/**
 * Instantiate the Application Configuration Object
 */
$appConfig = AppConfig::getInstance();

/**
 * Check the minimum requirements for the application to run with no errors
 */
$appConfig->checkForMinimumRequirements();

/**
 * Load the application paths
 */
$appConfig->loadAppPaths();

/**
 * Load the mbstring extension default settings
 */
$appConfig->loadMBStringConfig();

/**
 * Instantiate the HTTP Request Object
 */
$request = new Request;

/**
 * Instantiate the HTTP Response Object
 */
$response = new Response;

/**
 * Instantiate the Routing Table and the APP Router
 */
$routeCollection = $appConfig->loadRoutes();
$router = new Router;
$router->setRequest($request)
    ->setResponse($response)
    ->addRoutingTable($routeCollection)
    ->route();

/**
 * Instantiate the Template blocks and the Template Engine
 */
$templateBlocks = $appConfig->loadTemplateConfig();
$template = new Template($templateBlocks);

/**
 * Instantiate the session handler
 */
$appConfig->loadSessionConfig();
$session = new SessionManager;
$session->start();

/**
 * Instantiate the Registry Object
 */
$registry = Registry::getInstance();

/**
 * Add the HTTP Request Object to the app registry
 */
$registry->request = $request;

/**
 * Add the HTTP Response Object to the app registry
 */
$registry->response = $response;

/**
 * Add the Session Object to the app registry
 */
$registry->session = $session;

/**
 * Instantiate the FrontController Object
 */
$frontController = new FrontController($router, $registry, $template);