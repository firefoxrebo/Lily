<?php
namespace Lily;

define('CONFIG_FOLDER', APP_PATH . DS . 'config');

class AppConfig
{
    private static $instance;

    private function __construct ()
    {}

    private function __clone ()
    {}

    /**
     * @return AppConfig
     */
    public static function getInstance()
    {
        if(null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getRoutes()
    {
        return require_once CONFIG_FOLDER . DS . 'routes.php';
    }

    public function getAppPaths()
    {
        return require_once CONFIG_FOLDER . DS . 'paths.php';
    }

    public function getTemplateConfig()
    {
        return require_once CONFIG_FOLDER . DS . 'template.php';
    }
}