<?php
namespace Lily\Core\ACL;

class ReporterRole extends Role
{
    protected $roles = array(
        
        // General Roles
        '/',
        '/index',
        '/index/default',

        '/employee/profile',
        '/employee/password',
        
        '/settings',
        '/settings/default',

        '/mail',
        '/mail/default',
        '/mail/new',
        '/mail/view',
        '/mail/delete',
        '/mail/reply',
        '/mail/forward',
        '/mail/sent',
        
        '/notification',
        '/notification/view',
        '/notification/delete',

        '/overtime',
        '/overtime/default',
        '/overtime/add',
        '/overtime/view',
        
        '/auth/login',
        '/auth/logout',
        '/auth/denied',
        '/notfound',

        '/stats',
        '/stats/default',

        '/report',
        '/report/default',
        '/report/salesbranch',
        '/report/salesemp',
        '/report/setupinprogress',
        '/report/setupcompleted',
        '/report/setupemp',
        '/report/mtninprogress',
        '/report/mtnemergency'
    );
}