<?php
namespace Lily\Core\ACL;

class Role
{
    const MANAGER_ROLE = 1;
    const SALES_ROLE = 2;
    const DELIVERY_MAN_ROLE = 3;

    protected $roles = array();
    
    protected function __construct() {}
    
    private function __clone() {}
    
    public static function roleFactory($type)
    {
        $roleObj = null;
        switch ($type) {
            case self::MANAGER_ROLE:
                $roleObj = new ManagerRole;
                break;
            case self::SALES_ROLE:
                $roleObj = new SalesRole;
                break;
            case self::DELIVERY_MAN_ROLE:
                $roleObj = new ReporterRole;
                break;
        }
        return $roleObj;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
}
