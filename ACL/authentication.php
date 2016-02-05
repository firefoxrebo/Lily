<?php
namespace Lily\Core\ACL;

class Authentication
{
    use \Lily\Core\Helper;
    
    private static $instance;
    
    private function __construct() 
    {
        
    }
    
    private function __clone()
    {
        
    }
    
    public static function getInstance()
    {
        if(null === self::$instance)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function checkAuthentication()
    {
        if(isset($_SESSION['logged']) && $_SESSION['logged'] = 1)
        {
            return true ;
        } else {
            if(!isset($_SESSION['access_url'])) {
                $_SESSION['access_url'] = $_SERVER['REQUEST_URI'];
            }
            if($_SERVER['REQUEST_URI'] !== '/auth/login') {
                header('Location: /auth/login');
            }
        }
        return false;
    }
    
    public function canAccess($permissions)
    {
        preg_match('/(\\/[a-zA-Z0-9]+){0,2}/i', $_SERVER['REQUEST_URI'], $matches);
        $url = (empty($matches[0])) ? '/' : $matches[0];
        if(in_array($url, $permissions))
        {
            return true;
        } else {
            $this->routeTo("/notfound");
        }
        return false;
    }
}