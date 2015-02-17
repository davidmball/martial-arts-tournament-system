<?php
/**
 * Table Definition for competitor_events
 */
require_once 'DB/DataObject.php';

class DataObjects_Competitor_events extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'competitor_events';               // table name
    public $competitor_id;                   // int(20)  not_null
    public $event_id;                        // int(20)  not_null
    public $division_id;                     // int(20)  not_null
    public $draw_order;                      // int(11)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Competitor_events',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
