<?php
namespace Lily\Registry;

class Registry
{

    private static $instance;

    private function __construct ()
    {}

    private function __clone ()
    {}
    
    public static function getInstance()
    {
        if(null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __set($key, $value)
    {
        $this->$key = $value;
    }
    
    public function __get($key)
    {
        if(property_exists($this, $key)) {
            return $this->$key;
        }
    }
}