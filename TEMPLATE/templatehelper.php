<?php
namespace Lily\Template;

trait TemplateHelper
{
    public function highlightMenu($controller)
    {
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        @list($cont) = explode('/', $url, 2);
        if(!isset($cont) || empty($cont)) {
            $cont = 'index';
        }
        
        if($controller === strtolower($cont)) {
            return true;
        }
        
        return false;
    }
    
    public function highlightSubMenu($item)
    {
        $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        @list($cont, $action) = explode('/', $url, 3);
        if(!isset($action) || empty($action)) {
            $action = 'default';
        }
        if(is_array($item)) {
            if(in_array(strtolower($action), $item)) {
                return true;
            }
        } else {
            if($item === strtolower($action)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function enableMenu($userPrivilege, array $allowed) {
        if(in_array($userPrivilege, $allowed)) {
            return true;
        }
    }
    
    public function switchTo($type)
    {
        switch ($type) {
            case APP_ERROR:
                return 'error';
                break;
            case APP_INFO:
                return 'info';
                break;
            case APP_WARNING:
                return 'warning';
                break;
            case APP_SUCCESS:
                return 'success';
                break;
        }
    }
}