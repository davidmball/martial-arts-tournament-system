<?php
/**
 * Table Definition for sections
 */
require_once 'DB/DataObject.php';

class DataObjects_Sections extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'sections';                        // table name
    public $section_id;                      // int(11)  not_null primary_key
    public $tournament_id;                   // int(20)  not_null
    public $name;                            // string(30)  not_null
    public $date;                            // datetime(19)  not_null binary
    public $part;                            // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Sections',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
