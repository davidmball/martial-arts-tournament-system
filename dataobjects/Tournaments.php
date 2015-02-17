<?php
/**
 * Table Definition for tournaments
 */
require_once 'DB/DataObject.php';

class DataObjects_Tournaments extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tournaments';                     // table name
    public $tournament_id;                   // int(10)  not_null primary_key unsigned auto_increment
    public $name;                            // string(30)  not_null
    public $location;                        // string(30)  not_null
    public $date_from;                       // date(10)  not_null binary
    public $date_to;                         // date(10)  not_null binary
    public $allow_managers_to_edit;          // int(1)  not_null
    public $active;                          // int(1)  not_null
    public $last_updated;                    // datetime(19)  not_null binary
    public $draws_public;                    // int(4)  not_null
    public $payment_id;                      // int(6)  not_null
    public $due_date;                        // datetime(19)  not_null binary
    public $schedule_html;                   // blob(-1)  not_null blob
    public $participation_signature_html;    // blob(-1)  not_null blob
    public $tournament_form_pdf;             // string(50)  not_null
    public $logo_name;                       // string(30)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tournaments',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
