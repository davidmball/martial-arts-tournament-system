<?php
/**
 * Table Definition for competitors
 */
require_once 'DB/DataObject.php';

class DataObjects_Competitors extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'competitors';                     // table name
    public $competitor_id;                   // int(20)  not_null primary_key unsigned
    public $tournament_id;                   // int(20)  not_null
    public $enrolment;                       // string(15)  not_null
    public $title;                           // string(10)  not_null
    public $first_name;                      // string(30)  not_null
    public $middle_name;                     // string(30)  not_null
    public $last_name;                       // string(30)  not_null
    public $represents_id;                   // int(20)  not_null unsigned
    public $DOB;                             // date(10)  not_null binary
    public $weight;                          // real(22)  not_null
    public $height;                          // real(22)  not_null
    public $rank_id;                         // int(11)  not_null
    public $phone;                           // string(40)  not_null
    public $gender;                          // string(10)  not_null
    public $comments;                        // string(200)  
    public $last_updated;                    // datetime(19)  not_null binary
    public $red_card;                        // int(11)  
    public $paid_amount;                     // real(22)  not_null
    public $competitor_count;                // int(11)  not_null
    public $team_competitor_id1;             // int(20)  not_null
    public $team_competitor_id2;             // int(20)  not_null
    public $team_competitor_id3;             // int(20)  not_null
    public $team_competitor_id4;             // int(20)  not_null
    public $team_competitor_id5;             // int(20)  not_null
    public $team_competitor_id6;             // int(20)  not_null
    public $overall_place;                   // int(6)  not_null
    public $overall_description;             // string(30)  not_null
    public $received_form;                   // int(1)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Competitors',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
