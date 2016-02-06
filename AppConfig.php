<?php
namespace Lily;

use Lily\Template\TemplateBlocks;

define('CONFIG_FOLDER', APP_PATH . DS . 'config');

class AppConfig
{
    /**
     * @var AppConfig instance
     */
    private static $instance;

    /**
     * AppConfig constructor.
     */
    private function __construct ()
    {}

    /**
     * Preventing cloning the instance
     */
    private function __clone ()
    {}

    /**
     * Get A single instance of the AppConfig Class
     * @return AppConfig
     */
    public static function getInstance()
    {
        if(null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Loads the pre-defined routes of the application
     * @return mixed
     */
    public function loadRoutes()
    {
        return require_once CONFIG_FOLDER . DS . 'routes.php';
    }

    /**
     * Loads the pre-defined application paths
     * @return mixed
     */
    public function loadAppPaths()
    {
        return require_once CONFIG_FOLDER . DS . 'paths.php';
    }

    /**
     * Loads an instance of TemplateBlocks Class with
     * the required template parts
     * @return mixed
     */
    public function loadTemplateConfig()
    {
        return require_once CONFIG_FOLDER . DS . 'template.php';
    }

    /**
     * Loads the mbstring extension configuration
     * @return mixed
     */
    public function loadMBStringConfig()
    {
        return require_once CONFIG_FOLDER . DS . 'mbstring.php';
    }

    /**
     * Loads the session configuration file
     * @return mixed
     */
    public function loadSessionConfig()
    {
        return require_once CONFIG_FOLDER . DS . 'session.php';
    }

    /**
     * Check the PHP Environment for the minimum requirements
     * for the application to run
     */
    public function checkForMinimumRequirements()
    {
        $errorMessages = array();

        // Check if the php execution is not from a cli
        if(php_sapi_name() === 'cli') {
            $errorMessages[] = 'The Application must run on from a web server';
        }

        // Check if PHP version is 5.4+
        if(!version_compare(phpversion(), '5.4', '>')) {
            $errorMessages[] = '<strong>PHP version</strong> must be <strong>5.4</strong> or higher';
        }

        // Check if mcrypt extension is loaded
        if(!extension_loaded('mcrypt')) {
            $errorMessages[] = 'Your application need <strong>mcrypt</strong> extension to be compiled and loaded';
        }

        // Check if mbstring extension is loaded
        if(!extension_loaded('mbstring')) {
            $errorMessages[] = 'Your application need <strong>mbstring</strong> extension to be compiled and loaded';
        }

        if(!empty($errorMessages)) {
            exit(implode('<br>', $errorMessages));
        }
    }
}