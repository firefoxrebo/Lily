<?php
namespace Lily\Core\Security;

class CSRFSecHandler
{
    private static $instance;
    
    private function __construct() {}
    
    private function __clone() {}
    
    public static function getInstance()
    {
        if(null === self::$instance)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public function setupToken()
    {
        if(!isset($_SESSION['CSRFToken'])) {
            self::generateCSRFToken();
        }
    }
    
    private static function generateCSRFToken()
    {
        $_SESSION['CSRFToken'] = md5(rand(1, 1000000) . session_id() . time(). APP_SAULT);
    }
}