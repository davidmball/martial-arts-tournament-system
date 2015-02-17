<?php
/**
 * Table Definition for rank
 */
require_once 'DB/DataObject.php';

class DataObjects_Rank extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'rank';                            // table name
    public $rank_id;                         // int(11)  not_null primary_key
    public $name;                            // string(10)  not_null primary_key
    public $html_display;                    // string(100)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Rank',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
