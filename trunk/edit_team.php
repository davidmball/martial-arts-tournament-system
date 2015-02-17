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
if ($user_access != "admin" && $user_access != "manager") {
	$smarty->display('denied.tpl');
	exit;
}
$smarty->assign('current_menu', "Registration");

require 'utility.php';
echo "<br><br><br><br>";

//DB_DataObject::debugLevel(5);
// need to test that this person is a manager and can see/edit this persons details
// ie for if they attempt to edit the url
if ($user_access == "manager" && isset($_GET["ID"]) && $_GET["ID"] != "new") {
	$competitors = DB_DataObject::factory('competitors');
	$competitors->whereAdd("tournament_id = ".$competitors->escape($active_tournament->tournament_id));
	$competitors->competitor_id = $competitors->escape($_GET["ID"]);
	$competitors->find();
	$competitors->fetch();
	
	$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 	$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id); 	// zzz 	
 	$auth_represents_connection->whereAdd("represents_id = ".$competitors->represents_id);
	$auth_represents_connection->whereAdd("user_id = '".$user_id."'");
 	if ($auth_represents_connection->find() == 0)
 		$smarty->assign('access_denied', "You do not have permission to edit this competitor's details.");	
}

// need to check if the user is a manager and editing has been disabled for managers
if ($user_access == "manager" && !$active_tournament->allow_managers_to_edit)
	$smarty->assign('access_denied', "Managers are currently not allowed to edit competitor details.");	

$delete_success = false;
$user_input_passed = true;				
		
if(isset($_POST["Submit"])) {
	
	$smarty->clear_cache('registration.tpl');
	
	if (!isset($_POST["Events"])) {
		$primary = "No event was selected";
		$user_input_passed = false;	
	}
	
	if (!$user_input_passed) {
		$primary = "Competitor has not been added/updated because:\n".$primary;
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 
	} else if ($_POST["ID"] == "new") {
		$competitor = DB_DataObject::factory('competitors');
		$competitor->tournament_id = $active_tournament->tournament_id;
		$competitor->enrolment = "Team";
		$competitor->title = "";
		$competitor->first_name = strip_tags($_POST["Team_Name"]);
		$competitor->middle_name = "";		
		$competitor->last_name = "";
		$competitor->DOB ="0000-00-00";
		$competitor->weight = 0;
		$competitor->form_weight = 0;
		$competitor->height = 0;
		$competitor->rank_id = 0;
		$competitor->address = "";
		$competitor->phone = 0;
		$competitor->gender = "";
		$competitor->represents_id = strip_tags($_POST["Represents"]);
		$competitor->comments = strip_tags($_POST["Comments"]);
		$competitor->red_card = "";		
		$competitor->last_updated = date("Y-m-d H:i:s");

		$competitor->overall_place = 0;
		$competitor->overall_description = "";
		
		$competitor_count = 0;
		if ($_POST["Team_Competitor_id1"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id2"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id3"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id4"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id5"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id6"] != 0) $competitor_count++;												
		$competitor->competitor_count = $competitor_count;
		
		$competitor->team_competitor_id1 = $_POST["Team_Competitor_id1"];
		$competitor->team_competitor_id2 = $_POST["Team_Competitor_id2"];
		$competitor->team_competitor_id3 = $_POST["Team_Competitor_id3"];
		$competitor->team_competitor_id4 = $_POST["Team_Competitor_id4"];
		$competitor->team_competitor_id5 = $_POST["Team_Competitor_id5"];
		$competitor->team_competitor_id6 = $_POST["Team_Competitor_id6"];				
								
		$competitor->paid_amount = 0;					
		if (!($new_id = $competitor->insert())) {
			$primary = "Team has not been added";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Team (".$new_id.") has been added";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	

	} else {

		$competitor = DB_DataObject::factory('competitors');
		$competitor->get($_POST["ID"]);
		$competitor->tournament_id = $active_tournament->tournament_id;
		$competitor->enrolment = "Team";
		$competitor->title = "";
		$competitor->first_name = strip_tags($_POST["Team_Name"]);
		$competitor->middle_name = "";		
		$competitor->last_name = "";
		$competitor->DOB ="0000-00-00";
		$competitor->weight = 0;
		$competitor->form_weight = 0;
		$competitor->height = 0;
		$competitor->rank_id = 0;
		$competitor->address = "";
		$competitor->phone = 0;
		$competitor->gender = "";
		$competitor->represents_id = strip_tags($_POST["Represents"]);
		$competitor->comments = strip_tags($_POST["Comments"]);
		$competitor->red_card = "";		
		$competitor->last_updated = date("Y-m-d H:i:s");
		
		$competitor_count = 0;
		if ($_POST["Team_Competitor_id1"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id2"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id3"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id4"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id5"] != 0) $competitor_count++;
		if ($_POST["Team_Competitor_id6"] != 0) $competitor_count++;												
		$competitor->competitor_count = $competitor_count;
		
		$competitor->team_competitor_id1 = $_POST["Team_Competitor_id1"];
		$competitor->team_competitor_id2 = $_POST["Team_Competitor_id2"];
		$competitor->team_competitor_id3 = $_POST["Team_Competitor_id3"];
		$competitor->team_competitor_id4 = $_POST["Team_Competitor_id4"];
		$competitor->team_competitor_id5 = $_POST["Team_Competitor_id5"];
		$competitor->team_competitor_id6 = $_POST["Team_Competitor_id6"];				
								
		$competitor->paid_amount = 0;						
		if (!$competitor->update()) {
			$primary = "Team (".$_POST["ID"].") has not been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "error")); 
		} else {
			$primary = "Team (".$_POST["ID"].") has been updated";
			$smarty->assign(array('primary' => $primary, 'level' => "success"));  
		}	

	}

	// write the user selected events to an array
	// for all events in this tournament
	//   if it was user selected 
	//     if not in the table
	//		 create entry
	//   else
	//     if in the table
	//       remove entry
	if ($_REQUEST["ID"] == "new") {
		$edit_id = $new_id;
	} else {
		$edit_id = $_REQUEST["ID"];
	}
	$events = Array();
	while(current($_POST["Events"])) {
		$events[current($_POST["Events"])] = true; 
		next($_POST["Events"]);
	}		
	
	$tournament_events_list = DB_DataObject::factory('tournament_events');
	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$tournament_events_list->find();
	
	while ($tournament_events_list->fetch()) {
		
		// don't care about individual events
		$events_check = DB_DataObject::factory('events');
		$events_check->event_id = $tournament_events_list->event_id;
		$events_check->find();
		$events_check->fetch();
		if ($events_check->max_competitors > 1) {
	
			if (isset($events[$tournament_events_list->event_id])) {
				$competitor_events = DB_DataObject::factory('competitor_events');	
				$competitor_events->query("SELECT * FROM {$competitor_events->__table} WHERE competitor_id = '".$edit_id."' AND event_id = '".$tournament_events_list->event_id."'");
				if (!$competitor_events->fetch()) {
					$competitor_events = DB_DataObject::factory('competitor_events');	
					$competitor_events->competitor_id = $edit_id;
					$competitor_events->event_id = $tournament_events_list->event_id;
					$competitor_events->division_id = 0;	
					$competitor_events->insert();				
				}
			} else {
				$competitor_events = DB_DataObject::factory('competitor_events');	
				$competitor_events->query("SELECT * FROM {$competitor_events->__table} WHERE competitor_id = ".$edit_id." AND event_id = ".$tournament_events_list->event_id);
				if ($competitor_events->fetch()) {
					$competitor_events->delete();
					
					// if the event is no longer selected AND the competitor was in this event then need to 
					// remove them from the division list and reinit the division
					// note this function checks to see if they were only in the unassigned list
					Remove_Competitor_And_Init_Division($edit_id, $tournament_events_list->event_id);
				}				
			}
		}
		
	}
	

} elseif (isset($_POST["Delete"])) {
	
	$smarty->clear_cache('registration.tpl');
	
	$competitor = DB_DataObject::factory('competitors');
	$competitor->get($_POST["ID"]);
	if (!$competitor->delete()) {
		$primary = "Team (".$_POST["ID"].") has not been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "error")); 			
	} else {
		$delete_success = true;
		$primary = "Team (".$_POST["ID"].") has been deleted";
		$smarty->assign(array('primary' => $primary, 'level' => "success")); 		
	}
 
}

if (isset($_POST["Delete"]) && $delete_success == true) {

	$smarty->assign('delete_success', $delete_success);
	
	$tournament_events_list = DB_DataObject::factory('tournament_events');
	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
	$tournament_events_list->find();
	
	while ($tournament_events_list->fetch()) {
		Remove_Competitor_And_Init_Division($_POST["ID"], $tournament_events_list->event_id);
	}
	
	
} elseif ((isset($_GET["ID"]) && $_GET["ID"] == "new") || (!$user_input_passed)) {
	
	$command = "Enter details for a new team.";
	$smarty->assign("command", $command); 
	$smarty->assign('team', array('ID' => "new"));
	
} else {
//	if(!isset($_POST["Submit"])) {
		$command = "Edit details and submit, delete, or <a href=\"edit_team.php?ID=new\">add new team</a>.";
		$smarty->assign("command", $command); 
//	}
	$competitor = DB_DataObject::factory('competitors');
	if (isset($_POST["ID"]) && $_POST["ID"] == "new") {
		$competitor->competitor_id = $new_id;
	} else {
		$competitor->competitor_id = $_REQUEST["ID"];		
	}
	$competitor->whereadd("competitor_count <> 0");
	$competitor->find();
	$competitor->fetch();

	
	// check that this manager_id is allowed this to see this competitor details
	// else error
	
	$smarty->assign('team', array(
	      'ID'        			=> $competitor->competitor_id,
	      'TEAM_NAME'			=> stripslashes($competitor->first_name),
	      'TEAM_COMPETITOR_ID1'	=> $competitor->team_competitor_id1,
	      'TEAM_COMPETITOR_ID2'	=> $competitor->team_competitor_id2,
	      'TEAM_COMPETITOR_ID3'	=> $competitor->team_competitor_id3,
	      'TEAM_COMPETITOR_ID4'	=> $competitor->team_competitor_id4,	      
	      'TEAM_COMPETITOR_ID5'	=> $competitor->team_competitor_id5,
	      'TEAM_COMPETITOR_ID6'	=> $competitor->team_competitor_id6,	      	      	      	      
	      'COMMENTS'			=> $competitor->comments,
		  'LAST_UPDATED' 		=> $competitor->last_updated  
	       ));
	
	$smarty->assign('represents_selection', $competitor->represents_id);
	

	$competitor_events = DB_DataObject::factory('competitor_events');
	$competitor_events->competitor_id = $competitor->competitor_id;
	$competitor_events->find();
	$temp_selection_array = array();
	while ($competitor_events->fetch())  { 	
		$temp_selection_array[$competitor_events->event_id] = $competitor_events->event_id;
	}	
	$smarty->assign('events_selection', $temp_selection_array);

   
  	       
}

  	$temp_array = array();
 	$tournament_events_list = DB_DataObject::factory('tournament_events');
 	$tournament_events_list->tournament_id = $active_tournament->tournament_id;
 	$tournament_events_list->whereadd('max_competitors > 1');

	$events = DB_DataObject::factory('events');
	$tournament_events_list->selectAs();
	$tournament_events_list->joinAdd($events, "INNER", 'events', 'event_id');
	$tournament_events_list->selectAs($events, 'events_%s'); 	
  	$tournament_events_list->find();
  		
 	while ($tournament_events_list->fetch())
 		$temp_array[$tournament_events_list->event_id] = $tournament_events_list->events_name;
   $smarty->assign('events_list', $temp_array);  

 		// gets a list of possible represents
		$auth_represents_connection = DB_DataObject::factory('auth_represents_connection');
 		$auth_represents_connection->whereAdd("tournament_id = ".$active_tournament->tournament_id); 	// zzz
		$represents = DB_DataObject::factory('represents');
		$auth_represents_connection->selectAs();
		$auth_represents_connection->joinAdd($represents, "INNER", 'represents', 'represents_id');
		$auth_represents_connection->selectAs($represents, 'represents_%s');
	
		if ($user_access == "manager")
			$auth_represents_connection->user_id = $user_id;
		
		$auth_represents_connection->orderBy('represents_name');
		$auth_represents_connection->find();
		$temp_list_array = array();
		while ($auth_represents_connection->fetch())  { 	
			$temp_list_array[$auth_represents_connection->represents_id] = $auth_represents_connection->represents_name;
		}
		$smarty->assign('represents_list', $temp_list_array); 	
	
	
	// get a list of possible competitors	
	$competitor = DB_DataObject::factory('competitors');
	$competitor->tournament_id = $active_tournament->tournament_id;
	$competitor->whereadd("competitor_count = 0");
	$competitor->orderBy("last_name ASC");
	$competitor->find();	
	$temp2_list_array = array();
	$temp2_list_array[0] = "None (0)";
	while ($competitor->fetch())  { 	
		$temp2_list_array[$competitor->competitor_id] = stripslashes($competitor->last_name.", ".$competitor->first_name."  (".$competitor->competitor_id.") ");
	}
	$smarty->assign('competitors_select_list', $temp2_list_array); 

		
	$smarty->display('edit_team.tpl');

?>