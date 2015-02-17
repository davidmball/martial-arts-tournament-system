<?php
/**
 * Table Definition for divisions
 */
require_once 'DB/DataObject.php';

class DataObjects_Divisions extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'divisions';                       // table name
    public $division_id;                     // int(20)  not_null primary_key
    public $name;                            // string(50)  not_null
    public $event_id;                        // int(20)  not_null
    public $tournament_id;                   // int(20)  not_null
    public $rounds;                          // int(11)  not_null
    public $round_min;                       // real(22)  not_null
    public $break_min;                       // real(22)  not_null
    public $minor_final;                     // string(10)  not_null
    public $type;                            // string(15)  not_null
    public $section_id;                      // int(11)  not_null
    public $technique1;                      // string(30)  not_null
    public $technique2;                      // string(30)  not_null
    public $technique3;                      // string(30)  not_null
    public $technique4;                      // string(30)  not_null
    public $technique5;                      // string(30)  not_null
    public $sequence;                        // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Divisions',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
