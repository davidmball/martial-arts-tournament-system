<?php
/**
 * Table Definition for auth
 */
require_once 'DB/DataObject.php';

class DataObjects_Auth extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'auth';                            // table name
    public $user_id;                         // int(20)  not_null primary_key unsigned auto_increment
    public $username;                        // string(50)  not_null unique_key
    public $password;                        // string(32)  not_null multiple_key
    public $access;                          // string(15)  not_null
    public $email;                           // string(40)  not_null
    public $represents_id;                   // int(20)  
    public $title;                           // string(10)  not_null
    public $first_name;                      // string(30)  not_null
    public $last_name;                       // string(30)  not_null
    public $active;                          // int(1)  not_null
    public $last_updated;                    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Auth',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
