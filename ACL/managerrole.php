<?php
namespace Lily\Core\ACL;

class ManagerRole extends Role
{
    protected $roles = array(

        '/employee',
        '/employee/default',
        '/employee/add',
        '/employee/edit',
        '/employee/delete',
        '/employee/view',
        '/employee/resetpassword',
        
        '/client',
        '/client/default',
        '/client/add',
        '/client/edit',
        '/client/delete',
        '/client/view',

        '/branch',
        '/branch/default',
        '/branch/add',
        '/branch/edit',
        '/branch/delete',

        '/companies',
        '/companies/default',
        '/companies/add',
        '/companies/edit',
        '/companies/delete',
        '/companies/view',

        '/cars',
        '/cars/default',
        '/cars/add',
        '/cars/edit',
        '/cars/delete',
        '/cars/view',

        '/orders',
        '/orders/default',
        '/orders/add',
        '/orders/edit',
        '/orders/delete',
        '/orders/view',
        '/orders/qrcode',

        '/expenses',
        '/expenses/default',
        '/expenses/add',
        '/expenses/edit',
        '/expenses/delete',

        '/report',
        '/report/default',
        '/report/salesbranch',
        '/report/salesemp',
        '/report/setupinprogress',
        '/report/setupcompleted',
        '/report/setupemp',
        '/report/mtninprogress',
        '/report/mtnemergency',
        

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
        '/overtime/view',
        '/overtime/approve',
        
        '/auth/login',
        '/auth/logout',
        '/auth/denied',
        '/notfound',
        '/browser/usechrome'

    );
}