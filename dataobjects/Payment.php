<?php
/**
 * Table Definition for payment
 */
require_once 'DB/DataObject.php';

class DataObjects_Payment extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'payment';                         // table name
    public $payment_id;                      // int(6)  not_null
    public $description;                     // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Payment',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
