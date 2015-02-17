<?php
/*
    Martial Arts Tournament System (MATS)
    Copyright (C) 2015 David Ball (davidmichaelball @ gmail . com) and Ruth Schulz

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
require_once('../../tournament_settings.php');
require '../libs/Smarty.class.php';
$smarty = new Smarty;
require 'loginlogout.php';
require 'configDB.php';
require 'utility.php';

if (isset($_GET["SECTION"])) {
	$section = $_GET["SECTION"];
	
	if ($section == 0) {
		$smarty->assign('SECTION', "All");
	} else {
		$sections = DB_DataObject::factory('sections');
		$sections->tournament_id = $active_tournament->tournament_id;
		$sections->section_id = $section;
		$sections->find();
		$sections->fetch();
		$smarty->assign('SECTION', $sections->name);
	}
	
} else {
	$section = 0;	
		$smarty->assign('SECTION', "All");
}

$report = " ";

if (isset($_GET["REPORT"])) {
	$report = $_GET["REPORT"];
	
	$smarty->assign('REPORT', $report);
}

$competitors = DB_DataObject::factory('competitors');
$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));
if ($report == "FORM")
	$competitors->whereAdd("received_form =	0");
else if ($report == "PAYMENT")
	$competitors->whereAdd("paid_amount = 0");
else if ($report == "NOTENROLLED")
	$competitors->whereAdd("enrolment = 'Registered'");
	
$represents = DB_DataObject::factory('represents');
$competitors->selectAs();
$competitors->joinAdd($represents, "INNER", 'represents', 'represents_id');
$competitors->selectAs($represents, 'represent_%s');

$ranks = DB_DataObject::factory('rank');
$competitors->joinAdd($ranks, "INNER", 'rank', 'rank_id');
$competitors->selectAs($ranks, 'rank_%s');


if (!isset($_SESSION['sort_direction'])) {
	$_SESSION['sort_direction'] = "DESC";
}

$competitors->orderBy("last_name ASC");

$competitors->find();
 while ($competitors->fetch()) {
 	
	  // check if this competitor is in a division in this section
	  // not that unassigned competitors will not be shown unless section = 0
	  $competitor_in_section = 0;
	  if ($section != 0) {
		  $competitor_events = DB_DataObject::factory('competitor_events');
		  $competitor_events->competitor_id = $competitors->competitor_id;	  
		  $competitor_events->find();
		  while ($competitor_events->fetch() && !$competitor_in_section) {
				$tournament_divisions = DB_DataObject::factory('divisions');
				$tournament_divisions->tournament_id = $active_tournament->tournament_id;	
				$tournament_divisions->section_id = $section;
				$tournament_divisions->division_id = $competitor_events->division_id;
				if ($tournament_divisions->find()) {
					$competitor_in_section = 1;	
				}
		  }
	  }
	  
	  if ($competitor_in_section || $section == 0) { 
 		
	      $smarty->append('competitors', array(
		      'ID'        		=> $competitors->competitor_id,
		      'TITLE'			=> $competitors->title,
		      'FIRST_NAME'		=> stripslashes($competitors->first_name),
		      'MIDDLE_NAME'		=> stripslashes($competitors->middle_name),
		      'LAST_NAME' 		=> stripslashes($competitors->last_name),
		      'DOB'				=> $competitors->DOB,
		      'RANK'			=> $competitors->rank_name,
		      'REPRESENTS'		=> $competitors->represent_name,
		      'WEIGHT'			=> $competitors->weight,
		      'HEIGHT'			=> $competitors->height,
		      'ADDRESS'			=> $competitors->address,
		      'PHONE'			=> $competitors->phone,
		      'GENDER'			=> $competitors->gender,
		      'COMMENTS'		=> $competitors->comments,
		      'RED_CARD'		=> $competitors->red_card,      		      	      	      
			  'LAST_UPDATED' 	=> $competitors->last_updated,
			  'PAPERWORK_RECEIVED'		=> $competitors->received_form,		
			  'PAID_AMOUNT'		=> $competitors->paid_amount,
			  'ENROLMENT'		=> $competitors->enrolment,
			  'OWED_AMOUNT'		=> Get_Payment_Amount($active_tournament->payment_id, $competitors->competitor_id, $competitors->DOB, $active_tournament->tournament_id, $active_tournament->date_from)
	       ));
	
	       	$competitor_events = DB_DataObject::factory('competitor_events');
			$competitor_events->competitor_id = $competitors->competitor_id;
	
			$i = 0;
			$events_array = array();
			while (isset($active_tournament_events_id[$i])) {
				$competitor_events_c = clone $competitor_events;
				$competitor_events_c->whereAdd("competitor_events.event_id = ".$active_tournament_events_id[$i]);
				$events_array[$i] = $competitor_events_c->find();			
				$i++;	
			}
			$smarty->append('competitors_events', $events_array);
	  }
    }
    
$smarty->assign('user_represents', $user_represents);

$smarty->display('admin_report.tpl');


	
?>