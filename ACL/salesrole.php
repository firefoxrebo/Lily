<?php
namespace Lily\Core\ACL;

class SalesRole extends Role
{
    protected $roles = array(

        '/offer',
        '/offer/setup',
        '/offer/setupadd',
        '/offer/setupedit',
        '/offer/setupdelete',
        '/offer/setupview',
        '/offer/mtn',
        '/offer/mtnadd',
        '/offer/mtnedit',
        '/offer/mtndelete',
        '/offer/mtnview',

        '/contract',
        '/contract/setup',
        '/contract/setupadd',
        '/contract/setupedit',
        '/contract/setupdelete',
        '/contract/setupview',
        '/contract/setuppay',
        '/contract/mtn',
        '/contract/mtnadd',
        '/contract/mtnedit',
        '/contract/mtndelete',
        '/contract/mtnview',
        '/contract/mtnpay',

        '/subcontract',
        '/subcontract/default',
        '/subcontract/add',
        '/subcontract/edit',
        '/subcontract/delete',
        '/subcontract/view',

        '/client',
        '/client/default',
        '/client/add',
        '/client/edit',
        '/client/delete',
        '/client/view',
        
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
        '/notfound'
    );
}