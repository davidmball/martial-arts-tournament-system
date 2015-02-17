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
if ($user_access != "admin") {
	$smarty->display('denied.tpl');
	exit;
}
$smarty->assign('current_menu', "Main");

require 'utility.php';

$delete_success = false;
		
if(isset($_POST["Submit"])) {

	$smarty->clear_cache('registration.tpl');
	
	if ($_POST["ID"] == "new") {
		$tournament = DB_DataObject::factory('tournaments');
		$tournament->name = $_POST["Name"];
		$tournament->location = $_POST["Location"];
		$tournament->date_from = $_POST["From_Year"]."-".$_POST["From_Month"]."-".$_POST["From_Day"];
		$tournament->date_to = $_POST["To_Year"]."-".$_POST["To_Month"]."-".$_POST["To_Day"];
 		$tournament->allow_managers_to_edit = isset($_POST["Allow_Managers_To_Edit"]);
 		$tournament->draws_public = isset($_POST["Draws_Public"]);
 		$tournament->payment_id = $_POST["Payment"];
 		$tournament->due_date = $_POST["DueDate_Year"]."-".$_POST["DueDate_Month"]."-".$_POST["DueDate_Day"];		
 		$tournament->active = false;
			// do not strip schedule tags	
 		$tournament->schedule_html = $_POST["Schedule_HTML"];		
 		$tournament->participation_signature_html = $_POST["Participation_Signature_HTML"];	 		
		$tournament->last_updated = date("Y-m-d H:i:s");
		$tournament->tournament_form_pdf = $_POST["Tournament_Form_PDF"];				
		$tournament->logo_name = $_POST["Logo_Name"];
		if (!($new_id = $tournament->insert())) {
			$primary = "Tournament has not been added";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {		
			$primary = "Tournament (".$new_id.") has been added";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  	
			$tournament_events = DB_DataObject::factory('tournament_events');
			$tournament_events->tournament_id = $new_id;
			while ($temp_value = current($_POST["Events"])) {
				$tournament_events->event_id = $temp_value;
				$tournament_events->insert();
				next($_POST["Events"]);
			}					
		}	
				
	} else {

		$tournament = DB_DataObject::factory('tournaments');
		$tournament->get($_POST["ID"]);
		$tournament->name = $_POST["Name"];
		$tournament->location = $_POST["Location"];
		$tournament->date_from = $_POST["From_Year"]."-".$_POST["From_Month"]."-".$_POST["From_Day"];
		$tournament->date_to = $_POST["To_Year"]."-".$_POST["To_Month"]."-".$_POST["To_Day"];
		$tournament->allow_managers_to_edit = isset($_POST["Allow_Managers_To_Edit"]);
		$tournament->draws_public = isset($_POST["Draws_Public"]);
 		$tournament->payment_id = $_POST["Payment"];
 		$tournament->due_date = $_POST["DueDate_Year"]."-".$_POST["DueDate_Month"]."-".$_POST["DueDate_Day"];		
		// do not strip schedule tags
 		$tournament->schedule_html = $_POST["Schedule_HTML"];	
 		$tournament->participation_signature_html = $_POST["Participation_Signature_HTML"];	 		
		$tournament->last_updated = date("Y-m-d H:i:s");
		$tournament->tournament_form_pdf = $_POST["Tournament_Form_PDF"];				
		$tournament->logo_name = $_POST["Logo_Name"];
		 		 		
		$tournament_events = DB_DataObject::factory('tournament_events');
		$tournament_events->tournament_id = $_POST["ID"];
		$tournament_events->find();
		while ($tournament_events->fetch()) {
			$tournament_events->delete();	
		}
		$tournament_events = DB_DataObject::factory('tournament_events');
		$tournament_events->tournament_id = $_POST["ID"];
		while ($temp_value = current($_POST["Events"])) {
			$tournament_events->event_id = $temp_value;
			$tournament_events->insert();
			next($_POST["Events"]);
		}	
	
		
		$tournament->last_updated = date("Y-m-d H:i:s");
		if (!$tournament->update()) {
			$primary = "Tournament (".$_POST["ID"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Tournament (".$_POST["ID"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}
		
	}



	
} elseif (isset($_POST["Delete"])) {
	
	$smarty->clear_cache('registration.tpl');
	
	$tournament = DB_DataObject::factory('tournaments');
	$tournament->get($_POST["ID"]);
	if (!$tournament->delete()) {
		$primary = "Tournament (".$_POST["ID"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "Tournament (".$_POST["ID"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
		
		// also need to delete all the competitors that were in this tournament
		
		$competitors = DB_DataObject::factory('competitors');
		$competitors->tournament_id = $_POST["ID"];
		$competitors->find();
		while ($competitors->fetch()) {			
			
			// and the competitor event entries
			$competitor_events = DB_DataObject::factory('competitor_events');
			$competitor_events->competitor_id = $competitors->competitor_id;
			$competitor_events->find();
			while($competitor_events->fetch()) {
				$competitor_events->delete();	
			}

			$competitors->delete();
		}		
		
		// and need to delete the divisions
		$divisions = DB_DataObject::factory('divisions');
		$divisions->tournament_id = $_POST["ID"];
		$divisions->find();
		while ($divisions->fetch()) {
			
			// and the results
			$results = DB_DataObject::factory('results');
			$results->division_id = $divisions->division_id;
			$results->find();
			while($results->fetch()) {
				$results->delete();	
			}
		
			$divisions->delete();	
		}
		
		// and the sections
		$sections = DB_DataObject::factory('sections');
		$sections->tournament_id = $_POST["ID"];
		$sections->find();
		while ($sections->fetch()) {	
			$sections->delete();	
		}		
		
		// and the events
		$tournament_events = DB_DataObject::factory('tournament_events');
		$tournament_events->tournament_id = $_POST["ID"];
		$tournament_events->find();
		while ($tournament_events->fetch()) {	
			$tournament_events->delete();	
		}		
				
	}
 
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);

} elseif (isset($_GET["ID"]) && $_GET["ID"] == "new") {
	
	$command = "Enter details for a new tournament.";
	$smarty->assign("command", $command); 
	$smarty->assign('tournament', array('ID' => "new"));
	
} else {

	$command = "Edit details and submit or delete.";
	$smarty->assign("command", $command); 

	$tournament = DB_DataObject::factory('tournaments');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$tournament->tournament_id = $new_id;
	} else {
		$tournament->tournament_id = $_REQUEST["ID"];		
	}
	$tournament->find();
	$tournament->fetch();

	$smarty->assign('tournament', array(
	      'ID'        												=> $tournament->tournament_id,
	      'NAME' 												=> $tournament->name,     
	      'LOCATION'  										=> $tournament->location,     
	      'DATE_FROM'     								=> $tournament->date_from,
	      'DATE_TO' 											=> $tournament->date_to,
	      'ALLOW_MANAGERS_TO_EDIT' 	=> $tournament->allow_managers_to_edit,
	      'DRAWS_PUBLIC'								=> $tournament->draws_public,
	      'ACTIVE'  											=> $tournament->active,	      
	      'LAST_UPDATED' 								=> $tournament->last_updated,
	      'DUE_DATE'										=> $tournament->due_date,  
	      'SCHEDULE_HTML'							=> stripslashes($tournament->schedule_html),
	      'PARTICIPATION_SIGNATURE_HTML' => $tournament->participation_signature_html,
	      'TOURNAMENT_FORM_PDF' => $tournament->tournament_form_pdf,
	      'LOGO_NAME'									=> $tournament->logo_name
	       ));
	
	// get the events that are currently selected
		$tournament_events = DB_DataObject::factory('tournament_events');
		$tournament_events->tournament_id = $tournament->tournament_id;
		$tournament_events->find();
		$temp_selection_array = array();
		while ($tournament_events->fetch())  { 	
			$temp_selection_array[$tournament_events->event_id] = $tournament_events->event_id;
		}	
		$smarty->assign('events_selection', $temp_selection_array);
}

	if (isset($_GET["ID"]) && $_GET["ID"] == "new") {
		$smarty->assign('payment_selection', 0);
	} else { 
   		$smarty->assign('payment_selection', $tournament->payment_id);     
	}
	
	// get the different types of payment breakdown methods allowed
  	$temp_array = array();
 	$payment_list = DB_DataObject::factory('payment');
 	$payment_list->orderBy('payment_id');
 	$payment_list->find();
 	while ($payment_list->fetch())
 		$temp_array[$payment_list->payment_id] = $payment_list->description;
   $smarty->assign('payment_list', $temp_array);

	// get a list of all the possible events
  	$temp_array = array();
 	$events_list = DB_DataObject::factory('events');
 	$events_list->orderBy('name');
 	$events_list->find();
 	while ($events_list->fetch())
 		$temp_array[$events_list->event_id] = $events_list->name;
   $smarty->assign('events_list', $temp_array);  

$smarty->display('edit_tournament.tpl');

?>
